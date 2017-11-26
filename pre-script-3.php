<?php

if (!file_exists("../../../../seleniumMonitor/local/")) 
{
	mkdir("../../../../seleniumMonitor/local/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/local/");

//TRUE for no check, or filename / path for check
?>