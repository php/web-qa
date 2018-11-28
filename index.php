<?php
include("include/functions.php");
include("include/release-qa.php");

$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();

?>
           <h1>Welcome to the PHP Quality Assurance Team Web Page.</h1>
           <p>
            The PHP Quality Assurance Team supports the PHP Development Team by
            providing them with information on compatibility and stability issues.
           </p>

            <h3>Make test results:</h3>
            <ul>
            <li>
              All users who compile PHP are encouraged to run '<a href="/running-tests.php">make test</a>', which
              runs the test suite and optionally sends the results to this site to be compiled into <a href="reports/">reports for analysis</a>.
            </li>
            <li>
             Additional test results are available at <a href="http://gcov.php.net/">gcov.php.net</a>.
            </li>
           </ul>

            <h3>Available QA Releases:</h3>
<?php show_release_qa($QA_RELEASES); ?>
             <p>
              <br>
              <strong>Windows users:</strong>
              See <a href="https://windows.php.net/qa/">here</a> for the Windows QA builds and
              <a href="https://windows.php.net/snaps/">here</a> for the Windows Snapshot builds.
             </p>

             <h3>How To Help</h3>
             <p>
              If you would like to contribute to these efforts, please
              visit our <a href="howtohelp.php">How To Help</a> page.
             </p>
<?php

common_footer();

function show_release_qa($QA_RELEASES) {
	// The checksum configuration array
	global $QA_CHECKSUM_TYPES;

	echo "<!-- RELEASE QA -->\n";

	if (!empty($QA_RELEASES['releases'])) {

		$plural = count($QA_RELEASES['releases']) > 1 ? 's' : '';

		// QA Releases
		echo "<span class='lihack'>\n";
		echo "Providing QA for the following <a href='/rc.php'>test release{$plural}</a>:<br> <br>\n";
		echo "</span>\n";
		echo "<table>\n";

		foreach ($QA_RELEASES['releases'] as $pversion => $info) {

			echo "<tr>\n";
			echo "<td colspan=\"" . (sizeof($QA_CHECKSUM_TYPES) + 1) . "\">\n";
			echo "<h3 style=\"margin: 0px;\">{$info['version']}</h3>\n";
			echo "</td>\n";
			echo "</tr>\n";

			foreach ($info['files'] as $file_type => $file_info) {
				echo "<tr>\n";
				echo "<td width=\"20%\"><a href=\"{$file_info['path']}\">php-{$info['version']}.tar.{$file_type}</a></td>\n";

				foreach ($QA_CHECKSUM_TYPES as $algo) {
					echo '<td>';
					echo '<strong>' . strtoupper($algo) . ':</strong> ';

					if (isset($file_info[$algo]) && strlen($file_info[$algo])) {
						echo $file_info[$algo];
					} else {
						echo '(<em><small>No checksum value available</small></em>)&nbsp;';
					}

					echo "</td>\n";
				}

				echo "</tr>\n";
			}
		}

		echo "</table>\n";
	} else {
		echo "<span class='lihack'>There are no QA releases available at the moment to test.</span>";
	}

	echo "<!-- END -->\n";
}
