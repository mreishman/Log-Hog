<?php

if (!file_exists("../../../../search/update/")) 
{
	mkdir("../../../../search/update/", 0777, true);
}

sleep(3);

echo json_encode("../../search/update/");

//TRUE for no check, or filename / path for check
?>