<?php
include("include/freeTemplate.class.php");
include("include/functions.php");

$qa_cl = new freeTemplate;

	$qa_cl->assignTemplate($template_array["home"]);
	replace_default($qa_cl);
	
	$qa_cl->printTemplate();

unset($qa_cl);
?>