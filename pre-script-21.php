<?php

if (!file_exists("../../../../seleniumMonitor/local/default/conf/")) 
{
	mkdir("../../../../seleniumMonitor/local/default/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/local/default/conf/");

//TRUE for no check, or filename / path for check
?>