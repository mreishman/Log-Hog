<?php

if (!file_exists("../../../../search/core/img/")) 
{
	mkdir("../../../../search/core/img/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/img/");

//TRUE for no check, or filename / path for check
?>