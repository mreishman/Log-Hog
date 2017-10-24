<?php

if (!file_exists("../../../../search/core/php/")) 
{
	mkdir("../../../../search/core/php/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/php/");

//TRUE for no check, or filename / path for check
?>