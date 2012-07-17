function repoList(baseurl, org) {
    this.url = baseurl+'orgs/'+org+'/repos';
    this.data = {data:[]};
    var t = this;
    $("#backToRepolist").click(function (ev) { $.bbq.removeState('repo'); ev.preventDefault();});
}

repoList.prototype.showList = function() {
    $("#repolist").fadeIn();
    $("#backToRepolist").hide();
    $("#repoContent").fadeOut();
    $("#mainContent").show();
    this.refreshView();
}

repoList.prototype.hideList = function() {
    $("#repolist").fadeOut();
    $("#mainContent").hide();
    $("#backToRepolist").fadeIn();
}

repoList.prototype.refreshView = function() {
    $("#repolist").html($("#repoListItemTemplate").render(this.data.data));
    $("li", $("#repolist")).click(function(ev) { var reponame = loadRepo($(this).attr("repo")); $.bbq.pushState({ repo: reponame }); ev.preventDefault(); });
}
repoList.prototype.update = function() {
    var t = this;
    $("#loading").show();
    $.ajax({ dataType: 'jsonp', url: this.url, success: function(d) { t.setData(d); $("#loading").hide(); } });
}
repoList.prototype.setData = function(data) {
    this.data = data;
    this.refreshView();
}

function loginHandler() {
    var t = this;
    this.user = false;
    this.logindialog = $("#loginDialog").dialog({autoOpen: false});	 
    this.checkLoggedIn();
    $("#notloggedin").click(function(ev) {
        t.showLoginForm();
        ev.preventDefault();
    } );
    $("#loginBtn").click(function(ev) {
        t.logindialog.dialog("close");
        t.login();
        ev.preventDefault();
    } ); 
}

loginHandler.prototype.showLoginForm = function() {
    this.logindialog.dialog("open");
}

loginHandler.prototype.login = function() {
    var user = $("#userField").attr("value");
    var pass = $("#passField").attr("value");
    var t = this;

    $.ajax({ url: API_URL, type: "POST", data: { action: 'login', user: user, pass: pass }, success: function(d) { t.updateLoginState(d); } });
}

loginHandler.prototype.checkLoggedIn = function() {
    var t = this;
    $("#checkinglogin").show();
    $("#loggedin").hide();
    $("#notloggedin").hide();
    $.ajax({ url: API_URL+'?action=loggedin', success: function(d) { t.updateLoginState(d); } });
}

loginHandler.prototype.updateLoginState = function(d) {
    var t = this;
    if (d.success && d.user) {
        $("#checkinglogin").hide();
        $("#loggedin").html("Welcome "+d.user+" (<a href='#'>Logout</a>)").fadeIn();
        $("#notloggedin").hide();
        $("#loggedin a").click(function(ev) {
            $.ajax({ url: API_URL+'?action=logout', success: function(d) { t.updateLoginState(d); } });
            ev.preventDefault();
        });
        this.user = d.user;
    } else {
        $("#checkinglogin").hide();
        $("#loggedin").hide();
        $("#notloggedin").fadeIn();
        this.user = false;
    }
}

var repos;
var login;
var converter;

$(document).ready(function() {
    login = new loginHandler();
    repos = new repoList(GITHUB_BASEURL, GITHUB_ORG);
    converter = new Markdown.getSanitizingConverter();
    repos.update();

    $(window).bind( "hashchange", function(e) {
        if ($.bbq.getState("repo")) {
            repos.hideList();
        } else {
            $("#nextRepoPage").hide();
            repos.showList();
        }
    });

    $(window).trigger( "hashchange" );

    if ($.bbq.getState("repo")) {
        loadRepo($.bbq.getState("repo"));
    }
});

function loadRepo(repo, url) {
    $("#loading").show();
    url = url || GITHUB_BASEURL+'repos/'+GITHUB_ORG+"/"+repo+"/pulls";
    $.ajax({
        dataType: 'jsonp',
        url: url,
        success: function (data) {
            $("#loading").hide();
            if (data.meta && data.meta.Link) {
               for (i=0; i<data.meta.Link.length; i++) {
                   var link = data.meta.Link[i];
                   if (link[1].rel == "next") {
                       $("#nextRepoPage").show().click(function() {
                             $(this).hide();
                             loadRepo(repo, link[0]);
                       });
                       break;
                   }
               }
            } else {
               $("#nextRepoPage").hide();
            }
            for (var key in data.data) {
                data.data[key].body = converter.makeHtml(data.data[key].body);
            }
            $("#repoContent").html( $("#repoOverviewTemplate").render([{repoName: repo, pullList: $("#pullRequestListItem").render(data.data)}]));
            $("#repoContent code").parent('p').css('overflow', 'auto');
            $(".pullinstructions").click(function(ev) {
                $('<div></div>').html($("#pullInstructionTemplate").render({ repo: repo, number: $(this).attr("number")}))
                                .dialog({title: $(this).attr("number")+': '+$(this).attr("title")+' ('+$(this).attr("state")+')', width: 800 });
                ev.preventDefault();
            });
            $(".updatepullrequest").click(function(ev) {
                var dia = $('<div></div>').html($("#updatePullRequestTemplate").render({}))
                                          .dialog({title: $(this).attr("number")+': '+$(this).attr("title")+' ('+$(this).attr("state")+')' });
                $("button", dia).click(function(r, n, dia) { return function(ev) { updateRepo(r, n, dia); ev.preventDefault();}}(repo, $(this).attr("number"), dia) );
                ev.preventDefault();
            });
            $("#repoPullList").accordion({ autoHeight: false });
            $("#repoContent").show();
            $.bbq.pushState({ repo: repo });
        }
    });
 
}

function updateRepo(reponame, num, dia) {
    var t = this;
    if (!login.user) {
        login.showLoginForm();
        return;
    }
    $("#loading").show();
    $.ajax({ url: API_URL, type: "POST", data: {
        action: 'ghupdate',
        repo: reponame,
        id: num,
        state: $("select", dia).attr("value"),
        comment: $("textarea", dia).attr("value")
    }, success: function(d) {
        if (d.success) {
            loadRepo(reponame);
        } else {
            /* This might be reported in a nicer way ... */
            var message = "Failed while updating!";
            var key;
            for (key in d.errors) {
                message += "\n"+d.errors[key];
            }
	    window.alert(message);
        }
    }});
    dia.dialog("destroy");
}

