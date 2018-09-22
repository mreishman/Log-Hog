<?php
$fileName = $_POST['file'];
require_once("../../tmp/loghogBackupHistoryLogs/".$fileName);
echo json_encode($logData);