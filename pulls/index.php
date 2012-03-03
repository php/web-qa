<?php
include("../include/functions.php");
include("../include/release-qa.php");

$TITLE = "PHP-QA: GitHub Pull Requests";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();

?>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10"><img src="../gfx/spacer.gif" width="10" height="1"></td>
    <td width="100%">
    <style>
     #loading {
	     position:fixed;
	     top:50%;
	     padding-top:-20px;
	     height:40px;
	     left:50%;
	     padding-left:-50px;
	     width:100px;
	     border:1px solid black;
	     background-color: black;
	     color: white;
	     text-align: center;
	     vertical-align: center;
     }

     .ghuser {
	     border: 1px solid #ffcc66;
	     float: right;
	     margin-left: 5px;
	     margin-bottom: 5px;
     }

     .ghuser a {
	     color: #ffcc66;
	     text-decoration: none;
     }

     #loginstatus {
             width: 100%;
             text-align: right;
     }
   </style>
   <link href="http://code.jquery.com/ui/1.8.18/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
   <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
   <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
   <script type="text/javascript" src="jsrender.js"></script>
   <script id="repoListItemTemplate" type="text/x-jquery-tmpl">
	   <li repo="{{=name}}"><b><a href="#">{{=name}}:</a></b> {{=description}} ({{=open_issues}})</li>
   </script>
   <script id="repoOverviewTemplate" type="text/x-jquery-tmpl">
	   <h2>{{=repoName}}</h2>
	   <div id="repoPullList">
		   {{=pullList!}}
	   </div>
	   <!-- iframe style='width:100%; height:300px;border-width:1px;' src='' id='ghframe' name='ghframe'></iframe -->
   </script>
   <script id="pullRequestListItem" type="text/x-jquery-tmpl">
	   <h3><a href='#'>{{=number}}: {{=title}} ({{=state}})</a></h3>
	   <div class="pullrequest">
		   <div class="ghuser"><a href="{{=user.url}}"><img src="{{=user.avatar_url}}"><br>{{=user.login}}</a></div>
		   <div>Created: {{=created_at}}, LastUpdated: {{=updated_at}}</div>
		   <div>{{=body}}</div>
		   <div><a href="{{=html_url}}"><img src="../gfx/github.ico"> On GitHub</a> |
			<a href="{{=diff_url}}">Diff</a> |
			<a href="#" number="{{=number}}" state="{{=state}}" title="{{=title}}" class="pullinstructions">Show Pull Instructions</a> |
			<a href="#" number="{{=number}}" state="{{=state}}" title="{{=title}}" class="updatepullrequest">Update</a>
		   </div>
	   </div>
   </script>
   <script id="pullInstructionTemplate" type="text/x-jquery-tmpl">
	   <pre>
$ git fetch git://github.com/php/{{=repo}} pull/{{=number}}/head:pull-request/{{=number}}
$ git log -p pull-request/{{=number}} # REVIEW IT
$ git merge pull-request/{{=number}}  # Merge it, add a GOOD commit message
$ make test                  # you better don't forget that
$ git push origin master     # everything okay? good, let's push it
	   </pre>
   </script>
   <script id="updatePullRequestTemplate" type="text/x-jquery-tmpl">
       State: <select id="newState">
                <option>open</option>
                <option>closed</option>
              </select><br>
        Please provide a comment for your change:<br>
	<textarea id="comment"></textarea><br>
	<button>Go</button>
   </script>
   <script type="text/javascript">
     var GITHUB_BASEURL = "https://api.github.com/";
     var GITHUB_ORG     = "php";
     var API_URL        = "api.php";

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
   </script>
  <div id="loginstatus">
    <span id="checkinglogin">(checking login state ...)</span>
    <span id="loggedin"></span>
    <span id="notloggedin"><a href="#">Login</span>
  </div>
  <h1>Github Pull Requests</h1>
  <div id="backToRepolist"><a href="#">&lt;&lt;&lt-- Repos</a></div>
  <div id="mainContent"><ul id="repolist"></ul>The PHP project is using github to mirror its git repostories from <a href="http://git.php.net">git.php.net</a>.</div>
  <div id="repoContent"></div>
  <div id="loginDialog" title="Login">
    Username: <br><input id="userField"><br>
    Password: <br><input id="passField" type="password"><br>
    <button id="loginBtn">Login</button>
  </div>
  <div id="loading">Loading</div>

          </td>
          <td width="10"><img src="http://qa.php.net/gfx/spacer.gif" width="10" height="1"></td>
        </tr>
      </table>
<?php

common_footer();

