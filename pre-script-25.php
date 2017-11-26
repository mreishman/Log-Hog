<?php

if (!file_exists("../../../../seleniumMonitor/update/downloads/versionCheck/")) 
{
	mkdir("../../../../seleniumMonitor/update/downloads/versionCheck/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/update/downloads/versionCheck/");

//TRUE for no check, or filename / path for check
?>