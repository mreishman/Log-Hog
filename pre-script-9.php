<?php

if (!file_exists("../../../../search/setup/")) 
{
	mkdir("../../../../search/setup/", 0777, true);
}

sleep(3);

echo json_encode("../../search/setup/");

//TRUE for no check, or filename / path for check
?>