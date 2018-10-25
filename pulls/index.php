<?php
if (empty($_SERVER['HTTPS'])) {
    $host = preg_replace('/\s/', '', $_SERVER['HTTP_HOST']);
    header("Location: https://$host/pulls/");
    exit;
}

include("../include/functions.php");
include("../include/release-qa.php");

@include("./config.php");

$TITLE = "PHP-QA: GitHub Pull Requests";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();

?>
    <style type="text/css">
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
	     vertical-align: middle;
     }

     .pr-meta {
         font-size: 0.9em;
         margin-bottom: 20px;
     }

     #loginstatus {
             width: 100%;
             text-align: right;
     }

     #repoPullList code {
             white-space: pre;
     }

     #backToRepolist {
         float: left;
     }

     #repoContent {
         width: 920px;
         clear: both;
     }

     #nextRepoPage {
         float: right;
         display: none;
     }
   </style>
   <script id="repoListItemTemplate" type="text/x-jquery-tmpl">
	   <li data-repo="{{=name}}"><b><a href="#">{{=name}}:</a></b> {{=description}} ({{=open_issues}})</li>
   </script>
   <script id="repoOverviewTemplate" type="text/x-jquery-tmpl">
	   <h2>{{=repoName}}</h2>
	   <div id="repoPullList">
		   {{=pullList!}}
	   </div>
   </script>
   <script id="pullRequestListItem" type="text/x-jquery-tmpl">
	   <h3><a href='#'>{{=number}}: {{=title}} ({{=state}})</a></h3>
	   <div class="pullrequest">
		   <div class="pr-meta">Created by <a href="{{=user.html_url}}">{{=user.login}}</a> on {{=created_at}} (last updated {{=updated_at}})</div>
		   <div>{{=body!}}</div>
		   <div><a href="{{=html_url}}"><img src="../gfx/github.ico"> On GitHub</a> |
			<a href="{{=diff_url}}">Diff</a> |
			<a href="#" data-number="{{=number}}" data-state="{{=state}}" data-title="{{=title}}" class="pullinstructions">Show Pull Instructions</a> |
			<a href="#" data-number="{{=number}}" data-state="{{=state}}" data-title="{{=title}}" class="handlelabels">Labels</a> |
			<a href="#" data-number="{{=number}}" data-state="{{=state}}" data-title="{{=title}}" class="updatepullrequest">Update</a>
		   </div>
	   </div>
   </script>
   <script id="pullInstructionTemplate" type="text/x-jquery-tmpl">
	   <pre>
$ git checkout master     
$ wget https://github.com/php/{{=repo}}/pull/{{=number}}.patch # Download it
$ git am -3 {{=number}}.patch  # Merge it with a GOOD commit message
$ make test                    # you better not forget that
$ git push origin master       # everything okay? good, let's push it
	   </pre>
     <p>For a full detailed steps in how to merge into lower branches, check <a href="https://wiki.php.net/vcs/gitworkflow#reviewing_and_closing_pull_requests">our Git Workflow.</a></p>
   </script>
   <script id="labelsDialogTemplate" type="text/x-jquery-tmpl">
	<dd></dd>
	<button>OK</button>
   </script>
   <script id="updatePullRequestTemplate" type="text/x-jquery-tmpl">
       Labels: <span></span>
       State: <select id="newState">
                <option>open</option>
                <option>closed</option>
              </select><br>
        Please provide a comment for your change:<br>
	<textarea id="comment"></textarea><br>
	<button>Go</button>
   </script>
   <script>
     var GITHUB_BASEURL = <?php echo json_encode(GITHUB_BASEURL); ?>;
     var GITHUB_ORG     = <?php echo json_encode(GITHUB_ORG); ?>;
     var API_URL        = "api.php";
   </script>
  <div id="loginstatus">
    <span id="checkinglogin">(checking login state ...)</span>
    <span id="loggedin"></span>
    <span id="notloggedin"><a href="#">Login</a></span>
  </div>
  <h1>Github Pull Requests</h1>
<?php
if (!getenv('AUTH_TOKEN')) {
    echo '<div style="width: 100%; border: 2px solid red; padding:10px;"><b>Error:</b> AUTH_TOKEN not set</div><br>';
}

if (!constant('GITHUB_TOKEN')) {
    echo '<div style="width: 100%; border: 2px solid red; padding:10px;"><b>Error:</b> config.php not configured correctly.</div><br>';
    common_footer();
    exit;
}

?>
  <div id="backToRepolist"><a href="#">&lt;&lt;&lt-- Repos</a></div>
  <div id="nextRepoPage"><a href="javascript:void(0);">Next--&gt;&gt;&gt;</a></div>
  <div id="mainContent">
    <ul id="repolist"></ul>
    <p>Even though the PHP project is using <a href="https://git.php.net">git.php.net</a>
    as master location for Git repositories we provide official <a href="https://github.com/php">mirrors on GitHub</a>,
    which can be used to create and discuss feature branches. This tool here tries to assist with the handling of GitHub pull requests.
    </p>
    <p>In general discussions about pull requests should be done in the appropriate places
    (the actual pull request on GitHub, the php.net bug tracker, the PHP internals list, etc.)
    while this tool helps with tasks which can't be done as we don't make contributors to
    PHP actual members of the "PHP Organization" on GitHub. The most important function might
    be closing pull requests without applying the changes (if the changes are applied GitHub
    will close it automatically).
    </p>
    <p>Please note that this tool is in constant development and in an early state.
    For a more detailed overview on the PHP Git process please check the <a href="https://wiki.php.net/vcs/gitworkflow">Git Workflow page</a> on the Wiki.
    </p>
  </div>
  <div id="repoContent"></div>
  <div id="loginDialog" title="Login">
    Username: <br><input id="userField"><br>
    Password: <br><input id="passField" type="password"><br>
    <button id="loginBtn">Login</button>
  </div>
  <div id="loading">Loading</div>

  <link href="jquery-ui.css" rel="stylesheet" type="text/css"/>
<?php
$JS = [
    "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js",
    "//qa.php.net/pulls/jsrender.js",
    "//qa.php.net/pulls/pullrequests.js",
    "//qa.php.net/pulls/jquery.ba-bbq.min.js",
    "//qa.php.net/pulls/Markdown.Converter.js",
    "//qa.php.net/pulls/Markdown.Sanitizer.js",
];

common_footer($JS);
