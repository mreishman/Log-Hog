<?php

if (!file_exists("../../../../search/update/downloads/updateFiles/")) 
{
	mkdir("../../../../search/update/downloads/updateFiles/", 0777, true);
}

sleep(3);

echo json_encode("../../search/update/downloads/updateFiles/");

//TRUE for no check, or filename / path for check
?>