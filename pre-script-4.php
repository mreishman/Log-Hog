<?php

if (!file_exists("../../../../seleniumMonitor/run/")) 
{
	mkdir("../../../../seleniumMonitor/run/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/run/");

//TRUE for no check, or filename / path for check
?>