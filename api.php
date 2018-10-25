<?php

// Attempt to handle an API request of either following forms:
// api.php?type=qa-releases
// api.php?type=qa-releases&format=json
// api.php?type=qa-releases&format=serialize
//
// Missing format specifier will default to 'serialize'
// Output HTML help if type arg is missing or invalid.
(function() {
	require 'include/release-qa.php';
	!empty($QA_RELEASES) or die('Major Fail: $QA_RELEASES is empty.');

	switch ($_GET['type'] ?? null) {
		case 'qa-releases':
			$output = $QA_RELEASES;
			if (($_GET['only'] ?? null) === 'dev_versions') {
				$output = $output['reported'];
			}
			break;
		default:
			return;
	}

	switch ($_GET['format'] ?? null) {
		case 'json':
			echo json_encode($output);
			exit;
		case 'serialize':
		default:
			echo serialize($output);
			exit;
	}
})();

// Fallback on presenting documentation for this script.
require 'include/functions.php';

$TITLE       = "QA API";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
common_header();
?>
<p>
The QA API is simple, and is based on the query string.
Pass in type=qa-releases (the only type currently), along with the desired format (serialize or json).
</p>

<p>
Example URLs:
<ul>
<li>All information, serialized: <a href="api.php?type=qa-releases&format=serialize">https://qa.php.net/api.php?type=qa-releases&format=serialize</a></li>
<li>Only dev version numbers, json: <a href="api.php?type=qa-releases&format=json&only=dev_versions">https://qa.php.net/api.php?type=qa-releases&format=json&only=dev_versions</a></li>
</ul>
</p>
<?php
common_footer();
