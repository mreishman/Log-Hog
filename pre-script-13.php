<?php

if (!file_exists("../../../../search/core/conf/")) 
{
	mkdir("../../../../search/core/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/conf/");

//TRUE for no check, or filename / path for check
?>