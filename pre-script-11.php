<?php

if (!file_exists("../../../../seleniumMonitor/core/img/")) 
{
	mkdir("../../../../seleniumMonitor/core/img/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/img/");

//TRUE for no check, or filename / path for check
?>