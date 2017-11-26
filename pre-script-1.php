<?php

if (!file_exists("../../../../seleniumMonitor/")) 
{
	mkdir("../../../../seleniumMonitor/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/");

//TRUE for no check, or filename / path for check
?>