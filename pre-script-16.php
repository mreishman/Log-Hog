<?php

if (!file_exists("../../../../seleniumMonitor/local/default/")) 
{
	mkdir("../../../../seleniumMonitor/local/default/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/local/default/");

//TRUE for no check, or filename / path for check
?>