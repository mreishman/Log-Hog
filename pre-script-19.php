<?php

if (!file_exists("../../../../seleniumMonitor/core/php/upgradeScript/")) 
{
	mkdir("../../../../seleniumMonitor/core/php/upgradeScript/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/core/php/upgradeScript/");

//TRUE for no check, or filename / path for check
?>