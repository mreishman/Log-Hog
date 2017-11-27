<?php

if (!file_exists("../../../../seleniumMonitor/core/template/")) 
{
	mkdir("../../../../seleniumMonitor/core/template/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/template/");

//TRUE for no check, or filename / path for check
?>
