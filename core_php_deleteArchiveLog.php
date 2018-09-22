<?php
$fileName = $_POST['file'];
unlink("../../tmp/loghogBackupHistoryLogs/".$fileName);
echo json_encode(true);