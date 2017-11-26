<?php

if (!file_exists("../../../../seleniumMonitor/core/Themes/Default/template/")) 
{
	mkdir("../../../../seleniumMonitor/core/Themes/Default/template/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/Themes/Default/template/");

//TRUE for no check, or filename / path for check
?>