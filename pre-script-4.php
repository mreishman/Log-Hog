<?php
if (!file_exists("../../../../tmp/loghogBackupHistoryLogs/")) 
{
	mkdir("../../../../tmp/loghogBackupHistoryLogs/", 0777, true);
}
sleep(3);
echo json_encode("../../tmp/loghogBackupHistoryLogs/");
//TRUE for no check, or filename / path for check
?>
