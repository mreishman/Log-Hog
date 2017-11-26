<?php

if (!file_exists("../../../../seleniumMonitor/local/default/img/")) 
{
	mkdir("../../../../seleniumMonitor/local/default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/local/default/img/");

//TRUE for no check, or filename / path for check
?>