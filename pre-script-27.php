<?php

if (!file_exists("../../../../search/core/php/template/")) 
{
	mkdir("../../../../search/core/php/template/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/php/template/");

//TRUE for no check, or filename / path for check
?>