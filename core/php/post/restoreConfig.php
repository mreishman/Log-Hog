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
$restoreTo = settingsData::input($_POST["restoreTo"] ?? null, 0);
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../../local/".$currentSelectedTheme."/";
$settingsLock = settingsData::lock($baseUrl."conf");

$stem = $baseUrl.'conf/config';
$target = $stem.$restoreTo.'.json';
if ($restoreTo < 1 || !settingsData::exists($target))
{
	echo json_encode(false);
	exit();
}
$current = settingsData::read($stem.'.json', 'config');
$restored = settingsData::read($target, 'config');

$backups = [$current];
for ($index = $restoreTo + 1; settingsData::exists($file = $stem.$index.'.json'); $index++)
{
	$backups[] = settingsData::read($file, 'config');
}
foreach ($backups as $index => $backup)
{
	if (!settingsData::write($stem.($index + 1).'.json', $backup))
	{
		echo json_encode(false);
		exit();
	}
}
if (!settingsData::write($stem.'.json', $restored))
{
	echo json_encode(false);
	exit();
}
for ($index = count($backups) + 1; settingsData::exists($file = $stem.$index.'.json'); $index++)
{
	if (!settingsData::remove($file))
	{
		echo json_encode(false);
		exit();
	}
}

echo json_encode(true);
