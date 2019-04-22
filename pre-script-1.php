<?php
if (!file_exists("../../../../tmp/loghogBackupArchiveLogs/"))
{
	mkdir("../../../../tmp/loghogBackupArchiveLogs/", 0777, true);
}
sleep(3);
echo json_encode("../../tmp/loghogBackupArchiveLogs/");
//TRUE for no check, or filename / path for check
?>
