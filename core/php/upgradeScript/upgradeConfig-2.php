<?php
require_once("../commonFunctions.php");
require_once("../class/core.php");
$core = new core();
require_once("../class/upgrade.php");
$upgrade = new upgrade();
$upgrade->upgradeConfig($_POST['version']);

echo json_encode($_POST['version']);