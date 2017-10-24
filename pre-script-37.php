<?php

if (!file_exists("../../../../search/local/default/")) 
{
	mkdir("../../../../search/local/default/", 0777, true);
}

sleep(3);

echo json_encode("../../search/local/default/");

//TRUE for no check, or filename / path for check
?>