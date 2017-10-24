<?php

if (!file_exists("../../../../search/core/Themes/Default/img/")) 
{
	mkdir("../../../../search/core/Themes/Default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../search/core/Themes/Default/img/");

//TRUE for no check, or filename / path for check
?>