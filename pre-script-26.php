<?php

if (!file_exists("../../../../seleniumMonitor/core/Themes/Default/img/")) 
{
	mkdir("../../../../seleniumMonitor/core/Themes/Default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/Themes/Default/img/");

//TRUE for no check, or filename / path for check
?>