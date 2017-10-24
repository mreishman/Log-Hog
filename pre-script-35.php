<?php

if (!file_exists("../../../../search/core/Themes/Default/template/")) 
{
	mkdir("../../../../search/core/Themes/Default/template/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/Themes/Default/template/");

//TRUE for no check, or filename / path for check
?>