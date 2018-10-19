// Workaround for jquery.ba-bbq problems with newer jQuery version
// This library should be replaced with something what isn't unmaintained
// since 2010, though.
// @see https://github.com/cowboy/jquery-bbq/issues/52
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();

function repoList(baseurl, org) {
    this.url = baseurl+'orgs/'+org+'/repos?per_page=100';
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
    $("li", $("#repolist")).click(function(ev) { var reponame = loadRepo($(this).data("repo")); $.bbq.pushState({ repo: reponame }); ev.preventDefault(); });
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
        t.login();
        t.logindialog.dialog("close");
        ev.preventDefault();
    } );
}

loginHandler.prototype.showLoginForm = function() {
    this.logindialog.dialog("open");
}

loginHandler.prototype.login = function() {
    var user = $("#userField").val();
    var pass = $("#passField").val();
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
    $("#nextRepoPage").off();
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
                $('<div></div>').html($("#pullInstructionTemplate").render({ repo: repo, number: $(this).data("number")}))
                                .dialog({title: $(this).data("number")+': '+$(this).data("title")+' ('+$(this).data("state")+')', width: 800 });
                ev.preventDefault();
            });
            $(".handlelabels").click(function(ev) {
		    var that = $(this);
		    $("#loading").show();
		    $.ajax({dataType: "jsonp",
			   url: GITHUB_BASEURL+'repos/'+GITHUB_ORG+"/"+repo+"/labels",
			   success: function(repo_labels) {
				    $.ajax({dataType: "jsonp",
					   url: GITHUB_BASEURL+'repos/'+GITHUB_ORG+"/"+repo+"/issues/" + that.data("number") + "/labels",
					   success: function(issue_labels) {
						var dia = $('<div></div>').html($("#labelsDialogTemplate").render({}))
									  .dialog({title: that.data("number")+': '+that.data("title")+' ('+that.data("state")+')' });
						var ul_el = $("dd", dia).append('<ul style="list-style: none;">');
						for (var i in repo_labels.data) {

							var li_el, input_html, was_checked;

							li_el = ul_el.append('<li style="display: block;">')

							$('[id="pr-' + that.data("number") + '-label-' + repo_labels.data[i].name + '"]').each(function(i, v) {
								was_checked = v.checked;
								$(v).remove();
							});

							input_html ='<input type="checkbox" id="pr-' + that.data("number") + '-label-' + repo_labels.data[i].name + '"';
							for (var k in issue_labels.data) {
								if (repo_labels.data[i].id == issue_labels.data[k].id || was_checked) {
									input_html += ' checked="checked"';
									break;
								}
							}
							input_html += ' name="' + repo_labels.data[i].name + '"';
							input_html += " />";
							li_el.append(input_html +  repo_labels.data[i].name);
						}

						$("button", dia).click(function() { dia.dialog("close"); });
					   }
				    });
			 },
			 complete: function() {
				$("#loading").hide();
			}
		    });
		    ev.preventDefault();
            });
            $(".updatepullrequest").click(function(ev) {
                var dia = $('<div></div>').html($("#updatePullRequestTemplate").render({}))
                                          .dialog({title: $(this).data("number")+': '+$(this).data("title")+' ('+$(this).data("state")+')' });
                $("button", dia).click(function(r, n, dia) { return function(ev) { updateRepo(r, n, dia); ev.preventDefault();}}(repo, $(this).data("number"), dia) );

		var labels = $('[id^="pr-' + $(this).data("number") + '-label"]');
		if (0 == labels.length) {
			$("span", dia).append("<span>Unchanged</span>");
		} else {
			labels.each(function(i, v) {
				if (v.checked) {
					$("span", dia).append(v.name + " ");
				}
			});
		}
		$("span", dia).append("<br />");
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

    var labs_arg = null;
    var labs = $('[id^="pr-' + num + '-label"]');
    if (0 < labs.length) {
	labs_arg = [];
	labs.each(function(i, v){if(v.checked){labs_arg.push(v.name);}});
    }

    $("#loading").show();
    $.ajax({ url: API_URL, type: "POST", data: {
        action: 'ghupdate',
        repo: reponame,
        id: num,
        state: $("select", dia).val(),
        comment: $("textarea", dia).val(),
        labels: labs_arg
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
    }, complete: function() {
	$("#loading").hide();
    }});
    dia.dialog("destroy");
}
