<?php

if (!file_exists("../../../../seleniumMonitor/settings/")) 
{
	mkdir("../../../../seleniumMonitor/settings/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/settings/");

//TRUE for no check, or filename / path for check
?>