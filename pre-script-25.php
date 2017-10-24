<?php

if (!file_exists("../../../../search/core/Themes/")) 
{
	mkdir("../../../../search/core/Themes/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/Themes/");

//TRUE for no check, or filename / path for check
?>