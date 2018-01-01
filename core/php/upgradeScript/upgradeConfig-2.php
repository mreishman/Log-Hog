<?php
require_once("../commonFunctions.php");

upgradeConfig($_POST['version']);

echo json_encode($_POST['version']);