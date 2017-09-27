<?php

if (!file_exists("../../../../core/Themes/")) 
{
	mkdir("../../../../core/Themes/", 0777, true);
}

sleep(3);

echo json_encode("../../core/Themes/");

//TRUE for no check, or filename / path for check
?>
