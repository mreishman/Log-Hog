<?php

if (!file_exists("../../../../search/local/default/img/")) 
{
	mkdir("../../../../search/local/default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../search/local/default/img/");

//TRUE for no check, or filename / path for check
?>