<?php
$errors = [];
require('./config.php');
define('USER_AGENT', 'PHP Pull Request Admin (https://qa.php.net/pulls php-qa@lists.php.net)');

if ($_SERVER['SERVER_NAME'] === 'schlueters.de') {
	define('DEV', true);
	error_reporting(-1);
	ini_set('display_errors', 1);
} else {
	define('DEV', false);
}

function verify_password($user, $pass)
{
    global $errors;

    $post = http_build_query(
            [
                    'token' => getenv('AUTH_TOKEN'),
                    'username' => $user,
                    'password' => $pass,
            ]
    );

    $opts = [
            'method'        => 'POST',
            'header'        => 'Content-type: application/x-www-form-urlencoded',
            'content'       => $post,
    ];

    $ctx = stream_context_create(['http' => $opts]);

    $s = @file_get_contents('https://master.php.net/fetch/cvsauth.php', false, $ctx);

    $a = @unserialize($s);
    if (!is_array($a)) {
            $errors[] = "Failed to get authentication information.\nMaybe master is down?\n";
            return false;
    }
    if (isset($a['errno'])) {
            $errors[] = "Authentication failed: {$a['errstr']}\n";
            return false;
    }

    return true;
}

function verify_password_DEV($user, $pass)
{
	global $errors;
	$errors[] = "Unknown user $user (DEV)";
	return $user === 'johannes';
}

function do_http_request($url, $opts)
{
	global $errors;

	if (empty($opts['user_agent'])) {
		$opts['user_agent'] = USER_AGENT;
	}
	// IMPORTANT $opts might be logged. Make sure token is removed from log!
	$opts['header'] = 'Authorization: token '.GITHUB_TOKEN;

	$ctxt = stream_context_create(['http' => $opts]);

	$old_track_errors = ini_get('track_errors');
	ini_set('track_errors', true);
	$s = @file_get_contents($url, false, $ctxt);
	ini_set('track_errors', $old_track_errors);

	if (isset($_SESSION['debug']['requests'])) {
		// The token shall not be leaked!
		$opts['header'] = 'Authorization: token (secret)';
		$_SESSION['debug']['requests'][] = [
			'url' => $url,
			'opts'=> $opts,
			'headers' => $http_response_header,
			'response' => $s
		];
	}

	if (!$s) {
		$errors[] = "Server responded: ".$http_response_header[0];
		$errors[] = $php_errormsg;
		return false;
	}
	return $s;
}

function ghpostcomment($pull, $comment)
{
	global $errors;

	$post = json_encode(["body" => "**Comment on behalf of $_SESSION[user] at php.net:**\n\n$comment"]);


	$opts = [
		'method'        => 'POST',
		'content'       => $post,
	];

	return (bool)do_http_request($pull->_links->comments->href, $opts);
}

function ghchangestate($pull, $state)
{
	$content = json_encode(["state" => $state]);

	$opts = [
		'method'  => 'PATCH',
		'content' => $content
	];

	return (bool)do_http_request($pull->_links->self->href, $opts);
}

function ghsetlabels($pull, $labels)
{
	if (!is_array($labels)) {
		return true;
	}

	$opts = [
		'method'  => 'PUT',
		'content' => json_encode($labels),
	];

	$url = $pull->issue_url . "/labels";

	return (bool)do_http_request($url, $opts);
}

function login()
{
	global $errors;

	$func = DEV ? 'verify_password_DEV' : 'verify_password';
	if ($func($_POST['user'], $_POST['pass'])) {
		$_SESSION['user'] = $_POST['user'];
		die(json_encode(['success' => true, 'user' => $_POST['user']]));
	} else {
		header('HTTP/1.0 401 Unauthorized');
		$_SESSION['user'] = false;
		die(json_encode(['success' => false, 'errors' => $errors]));
	}
}

function logout()
{
	session_destroy();
	die(json_encode(['success' => true]));
}

function loggedin()
{
	$result = [
		'success' => !empty($_SESSION['user'])
	];
	if (!empty($_SESSION['user'])) {
		$result['user'] = $_SESSION['user'];
	}
	die(json_encode($result));
}

function ghupdate()
{
	global $errors;

	if (empty($_SESSION['user'])) {
		header('HTTP/1.0 401 Unauthorized');
		die(json_encode(['success' => false, 'errors' => ['Unauthorized']]));
	}

	if (empty($_POST['repo'])) {
		header('HTTP/1.0 400 Bad Request');
		die(json_encode(['success' => false, 'errors' => ["No repo provided"]]));
	}

	if (empty($_POST['id']) || !is_numeric($_POST['id'])) {
		header('HTTP/1.0 400 Bad Request');
		die(json_encode(['success' => false, 'errors' => ["No or invalid id provided"]]));
	}

	if (empty($_POST['comment']) || !($comment = trim($_POST['comment']))) {
		header('HTTP/1.0 400 Bad Request');
		die(json_encode(['success' => false, 'errors' => ["No comment provided"]]));
	}

	if (!empty($_POST['state']) && !in_array($_POST['state'], ['open', 'closed'])) {
		header('HTTP/1.0 400 Bad Request');
		die(json_encode(['success' => false, 'errors' => ["Invalid state"]]));
	}

	$url = GITHUB_BASEURL.'repos/'.GITHUB_ORG.'/'.urlencode($_POST['repo']).'/pulls/'.$_POST['id'];
	$ctxt = stream_context_create([
		'http' => [
			'ignore_errors' => '1',
			'user_agent' => USER_AGENT,
		]
	]);
	$pull_raw = @file_get_contents($url, false, $ctxt);
	$pull = $pull_raw ? json_decode($pull_raw) : false;
	if (!is_object($pull) || empty($pull->state)) {
		header('HTTP/1.0 400 Bad Request');
		if (isset($_SESSION['debug']['requests'])) {
			$_SESSION['debug']['requests'][] = [
				"message" => "Request to GitHub failed",
				"url" => $url,
				"http response" => $http_response_header,
				"response" => $pull_raw,
				"json error" => json_last_error()
			];
		}
		die(json_encode(['success' => false, 'errors' => ["Failed to get data from GitHub", "http" => $http_response_header, "json" => json_last_error()]]));
	}

	$comment = @get_magic_quotes_gpc() ? stripslashes($_POST['comment']) : $_POST['comment'];

	if (!ghpostcomment($pull, $comment)) {
		header('500 Internal Server Error');
		$errors[] = "Failed to add comment on GitHub";
		die(json_encode(['success' => false, 'errors' => $errors]));
	}

	if (!empty($_POST['state'])) {
		if (!ghchangestate($pull, $_POST['state'])) {
			header('500 Internal Server Error');
			$errors[] = "Failed to set new state";
			die(json_encode(['success' => false, 'errors' => $errors]));
		}
	}

	if (is_array($_POST['labels'])) {
		if (!ghsetlabels($pull, $_POST['labels'])) {
			header('500 Internal Server Error');
			$errors[] = "Failed to set labels";
			die(json_encode(['success' => false, 'errors' => $errors]));
		}
	}

	die(json_encode(['success' => true]));
}

function requestlog() {
	if (!isset($_SESSION['debug']['requests'])) {
		$_SESSION['debug']['requests'] = [];
	}

	header('Content-Type: text/plain');
	var_dump($_SESSION['debug']);
	exit;
}

header('Content-Type: application/json');
session_start();

$accepted_actions = [
	'login',
	'logout',
	'loggedin',
	'ghupdate',
	'requestlog'
];
if (isset($_REQUEST['action']) && in_array($_REQUEST['action'], $accepted_actions)) {
	$action = $_REQUEST['action'];
	$action();
} else {
	header('HTTP/1.0 400 Bad Request');
	die(json_encode(['success' => false, 'errors' => ["Unknown method"]]));
}
