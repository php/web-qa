<?php
require 'include/release-qa.php';
require 'include/functions.php';

$TITLE       = "QA API";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

$types   = array('qa-releases');
$formats = array('serialize', 'json');

if (empty($QA_RELEASES)) {
	die('Major Fail: $QA_RELEASES is empty.');
}

if (!empty($_GET['type'])) {
	
	if (!empty($_GET['only']) && $_GET['only'] === 'dev_versions') {
		$output = $QA_RELEASES['reported'];
	} else {
		$output = $QA_RELEASES;
	}
	
	$format = 'serialize';
	if (in_array($_GET['type'], $types)) {
		
		if (isset($_GET['format']) && in_array($_GET['format'], $formats)) {
			$format = $_GET['format'];
		}
		
		switch ($format) {
			case 'json':
				echo json_encode($output);
				break;
			case 'serialize':
				echo serialize($output);
				break;
		}
		exit;
	}
}

common_header();
?>
<p>
The QA API is simple, and is based on the query string. 
Pass in type=qa-releases (the only type currently), along with the desired format (serialize or json). 
</p>
<p>
Example URLs:
<ul>
<li>All information, serialized: <a href="api.php?type=qa-releases&format=serialize">http://qa.php.net/api.php?type=qa-releases&format=serialize</a></li>
<li>Only dev version numbers, json: <a href="api.php?type=qa-releases&format=json&only=dev_versions">http://qa.php.net/api.php?type=qa-releases&format=json&only=dev_versions</a></li>
</ul>

<?php
common_footer();
?>

