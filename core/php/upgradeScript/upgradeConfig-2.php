<?php
require_once("../commonFunctions.php");
require_once("../class/core.php");
$core = new core();
upgradeConfig($_POST['version']);

echo json_encode($_POST['version']);