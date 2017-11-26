<?php

if (!file_exists("../../../../seleniumMonitor/core/templates/")) 
{
	mkdir("../../../../seleniumMonitor/core/templates/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/templates/");

//TRUE for no check, or filename / path for check
?>