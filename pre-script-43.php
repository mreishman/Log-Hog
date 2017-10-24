<?php

if (!file_exists("../../../../search/local/default/template/")) 
{
	mkdir("../../../../search/local/default/template/", 0777, true);
}

sleep(3);

echo json_encode("../../search/local/default/template/");

//TRUE for no check, or filename / path for check
?>