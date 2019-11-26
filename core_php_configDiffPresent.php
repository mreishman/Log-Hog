<?php
require_once("../../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../local/".$currentSelectedTheme."/";
return json_encode(is_file(file_exists($baseUrl."conf/config1Diff.php")));