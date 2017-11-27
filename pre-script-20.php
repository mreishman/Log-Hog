<?php

if (!file_exists("../../../../seleniumMonitor/core/Themes/Default/")) 
{
	mkdir("../../../../seleniumMonitor/core/Themes/Default/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/Themes/Default/");

//TRUE for no check, or filename / path for check
?>
