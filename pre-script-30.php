<?php

if (!file_exists("../../../../monitor/core/php/upgradeScript/")) 
{
	mkdir("../../../../monitor/core/php/upgradeScript/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/php/upgradeScript/");

//TRUE for no check, or filename / path for check
?>