<?php

if (!file_exists("../../../../seleniumMonitor/update/downloads/")) 
{
	mkdir("../../../../seleniumMonitor/update/downloads/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/update/downloads/");

//TRUE for no check, or filename / path for check
?>