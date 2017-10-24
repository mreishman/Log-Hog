<?php

if (!file_exists("../../../../search/core/template/")) 
{
	mkdir("../../../../search/core/template/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/template/");

//TRUE for no check, or filename / path for check
?>