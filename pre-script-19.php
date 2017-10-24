<?php

if (!file_exists("../../../../search/core/js/")) 
{
	mkdir("../../../../search/core/js/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/js/");

//TRUE for no check, or filename / path for check
?>