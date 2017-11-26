<?php

if (!file_exists("../../../../seleniumMonitor/update/downloads/updateFiles/")) 
{
	mkdir("../../../../seleniumMonitor/update/downloads/updateFiles/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/update/downloads/updateFiles/");

//TRUE for no check, or filename / path for check
?>