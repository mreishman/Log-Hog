<?php

if (!file_exists("../../../../search/update/downloads/")) 
{
	mkdir("../../../../search/update/downloads/", 0777, true);
}

sleep(3);

echo json_encode("../../search/update/downloads/");

//TRUE for no check, or filename / path for check
?>