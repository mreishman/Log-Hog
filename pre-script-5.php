<?php

if (!file_exists("../../../../search/local/")) 
{
	mkdir("../../../../search/local/", 0777, true);
}

sleep(3);

echo json_encode("../../search/local/");

//TRUE for no check, or filename / path for check
?>