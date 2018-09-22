<?php
$scannedDir = scandir("../../tmp/loghogBackupHistoryLogs/");
if(!is_array($scannedDir))
{
	$scannedDir = array($scannedDir);
}
$files = array_diff($scannedDir, array('..', '.','placeholder .txt'));
foreach ($files as $file)
{
	if(is_file($file))
	{
		unlink($file);
	}
}
echo json_encode(true);