<?php

if (!file_exists("../../../../seleniumMonitor/core/js/")) 
{
	mkdir("../../../../seleniumMonitor/core/js/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/js/");

//TRUE for no check, or filename / path for check
?>