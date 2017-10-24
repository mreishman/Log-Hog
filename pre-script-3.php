<?php

if (!file_exists("../../../../search/core/")) 
{
	mkdir("../../../../search/core/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/");

//TRUE for no check, or filename / path for check
?>