<?php

if (!file_exists("../../../../search/update/downloads/versionCheck/")) 
{
	mkdir("../../../../search/update/downloads/versionCheck/", 0777, true);
}

sleep(3);

echo json_encode("../../search/update/downloads/versionCheck/");

//TRUE for no check, or filename / path for check
?>