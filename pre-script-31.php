<?php

if (!file_exists("../../../../search/core/Themes/Default/")) 
{
	mkdir("../../../../search/core/Themes/Default/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/Themes/Default/");

//TRUE for no check, or filename / path for check
?>