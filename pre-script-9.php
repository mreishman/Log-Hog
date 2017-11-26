<?php

if (!file_exists("../../../../seleniumMonitor/core/conf/")) 
{
	mkdir("../../../../seleniumMonitor/core/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/conf/");

//TRUE for no check, or filename / path for check
?>