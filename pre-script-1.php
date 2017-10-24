<?php

if (!file_exists("../../../../search/")) 
{
	mkdir("../../../../search/", 0777, true);
}

sleep(3);

echo json_encode("../../search/");

//TRUE for no check, or filename / path for check
?>