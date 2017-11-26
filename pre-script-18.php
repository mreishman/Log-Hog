<?php

if (!file_exists("../../../../seleniumMonitor/core/php/template/")) 
{
	mkdir("../../../../seleniumMonitor/core/php/template/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/php/template/");

//TRUE for no check, or filename / path for check
?>