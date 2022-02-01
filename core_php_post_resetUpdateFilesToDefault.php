<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
$session = new session();
require_once("../class/settingsInstallUpdate.php");
$settingsInstallUpdate = new settingsInstallUpdate();
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

$settingsInstallUpdate->updateProgressFile("Finished Updating to ", "../", "updateProgressFileNext.php", "finishedUpdate", 0);
$settingsInstallUpdate->updateProgressFile("Finished Updating to ", "../", "updateProgressFile.php", "finishedUpdate", 0);

echo json_encode(true);