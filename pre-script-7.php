<?php

if (!file_exists("../../../../seleniumMonitor/update/")) 
{
	mkdir("../../../../seleniumMonitor/update/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/update/");

//TRUE for no check, or filename / path for check
?>