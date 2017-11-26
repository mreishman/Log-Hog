<?php

if (!file_exists("../../../../seleniumMonitor/core/php/")) 
{
	mkdir("../../../../seleniumMonitor/core/php/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/php/");

//TRUE for no check, or filename / path for check
?>