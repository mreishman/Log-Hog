<?php

if (!file_exists("../../../../search/core/html/")) 
{
	mkdir("../../../../search/core/html/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/html/");

//TRUE for no check, or filename / path for check
?>