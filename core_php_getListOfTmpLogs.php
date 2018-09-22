<?php
$scannedDir = scandir("../../tmp/loghogBackupHistoryLogs/");
if(!is_array($scannedDir))
{
	$scannedDir = array($scannedDir);
}
$files = array_diff($scannedDir, array('..', '.','placeholder .txt'));
echo json_encode($files);