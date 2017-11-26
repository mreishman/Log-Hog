<?php

if (!file_exists("../../../../seleniumMonitor/core/html/")) 
{
	mkdir("../../../../seleniumMonitor/core/html/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/html/");

//TRUE for no check, or filename / path for check
?>