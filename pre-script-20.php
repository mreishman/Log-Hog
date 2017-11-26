<?php

if (!file_exists("../../../../seleniumMonitor/core/Theme/Default/")) 
{
	mkdir("../../../../seleniumMonitor/core/Theme/Default/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/Theme/Default/");

//TRUE for no check, or filename / path for check
?>