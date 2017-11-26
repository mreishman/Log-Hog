<?php

if (!file_exists("../../../../seleniumMonitor/core/")) 
{
	mkdir("../../../../seleniumMonitor/core/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/");

//TRUE for no check, or filename / path for check
?>