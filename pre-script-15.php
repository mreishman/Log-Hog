<?php

if (!file_exists("../../../../seleniumMonitor/core/Themes/")) 
{
	mkdir("../../../../seleniumMonitor/core/Themes/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/Themes/");

//TRUE for no check, or filename / path for check
?>