function repoList(baseurl, org) {
    this.url = baseurl+'orgs/'+org+'/repos';
    this.data = {data:[]};
    var t = this;
    $("#backToRepolist").click(function () { t.showList(); });
}

repoList.prototype.showList = function() {
    $("#repolist").fadeIn();
    $("#backToRepolist").hide();
    $("#repoContent").fadeOut();
    repos.refreshView();
}

repoList.prototype.hideList = function() {
    $("#repolist").fadeOut();
    $("#backToRepolist").fadeIn();
}

repoList.prototype.refreshView = function() {
    $("#repolist").html($("#repoListItemTemplate").render(this.data.data));
    $("#mainContent").show();
    $("li", $("#repolist")).click(function() { loadRepo($(this).attr("repo")); });
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
    $("#notloggedin").click(function() {
        t.showLoginForm();
    } );
    $("#loginBtn").click(function() {
        t.logindialog.dialog("close");
        t.login();
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
        $("#loggedin a").click(function() {
            $.ajax({ url: API_URL+'?action=logout', success: function(d) { t.updateLoginState(d); } });
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

$(document).ready(function() {
    login = new loginHandler();
    repos = new repoList(GITHUB_BASEURL, GITHUB_ORG);
    repos.update();
    repos.showList();
});

function loadRepo(repo) {
    $("#loading").show();
    $.ajax({
        dataType: 'jsonp',
        url: GITHUB_BASEURL+'repos/'+GITHUB_ORG+"/"+repo+"/pulls",
        success: function (data) {
            repos.hideList();
            $("#loading").hide();
            $("#mainContent").hide();
            $("#repoContent").html( $("#repoOverviewTemplate").render([{repoName: repo, pullList: $("#pullRequestListItem").render(data.data)}]));
            $(".pullinstructions").click(function() {
                $('<div></div>').html($("#pullInstructionTemplate").render({ repo: repo, number: $(this).attr("number")}))
                                .dialog({title: $(this).attr("number")+': '+$(this).attr("title")+' ('+$(this).attr("state")+')', width: 800 });
            });
            $(".updatepullrequest").click(function() {
                var dia = $('<div></div>').html($("#updatePullRequestTemplate").render({}))
                                          .dialog({title: $(this).attr("number")+': '+$(this).attr("title")+' ('+$(this).attr("state")+')' });
                $("button", dia).click(function(r, n, dia) { return function() { updateRepo(r, n, dia); }}(repo, $(this).attr("number"), dia) );
            });
            $("#repoPullList").accordion({ autoHeight: false });
            $("#repoContent").show();
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
    }, success: function(d) { repos.update(); } });
    dia.dialog("destroy");
}

