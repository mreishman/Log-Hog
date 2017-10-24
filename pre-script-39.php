<?php

if (!file_exists("../../../../search/local/default/conf/")) 
{
	mkdir("../../../../search/local/default/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../search/local/default/conf/");

//TRUE for no check, or filename / path for check
?>