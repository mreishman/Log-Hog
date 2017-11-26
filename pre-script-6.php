<?php

if (!file_exists("../../../../seleniumMonitor/setup/")) 
{
	mkdir("../../../../seleniumMonitor/setup/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/setup/");

//TRUE for no check, or filename / path for check
?>