<?php

if (!file_exists("../../../../monitor/update/downloads/versionCheck/")) 
{
	mkdir("../../../../monitor/update/downloads/versionCheck/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/update/downloads/versionCheck/");

//TRUE for no check, or filename / path for check
?>