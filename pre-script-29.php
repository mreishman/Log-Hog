<?php

if (!file_exists("../../../../search/core/php/upgradeScript/")) 
{
	mkdir("../../../../search/core/php/upgradeScript/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/php/upgradeScript/");

//TRUE for no check, or filename / path for check
?>