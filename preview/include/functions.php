<?php
/* (c)'2001 by Marco Kaiser (bate@php.net) and the PHP Group */
/* Read an Learn. Any Questions so ask. */

$default_placeholder = array(0 => array("[%TITLE%]",
										"PHP-QAT: Quality Assurance Team"),
							 
							 1 => array("[%CURRENT_DATE%]",
							 			date("l, F d, Y", time())),

							 2 => array("[%SITE_UPDATE%]",
							 			date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME)))
							);

$template_array = array("home" => "templates/tmpl_home.html",
						"projects" => "templates/tmpl_projects.html",
						"links" => "templates/tmpl_links.html",
						"members" => "templates/tmpl_members.html",
						"howtohelp" => "templates/tmpl_howtohelp.html",
						);

function replace_default(&$class) {
	foreach ($GLOBALS["default_placeholder"] as $key) {
		$class->replaceVar($key[0], $key[1]);
	}

return true;
}

function make_link($string, $text = "") {
}
							
?>