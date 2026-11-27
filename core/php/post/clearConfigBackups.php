<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
$settingsLock = settingsData::lock($baseUrl."conf");

for ($index = 1; settingsData::exists($file = $baseUrl.'conf/config'.$index.'.json'); $index++)
{
	if (!settingsData::remove($file))
	{
		echo json_encode(false);
		exit();
	}
}

echo json_encode(true);
