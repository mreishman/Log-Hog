<?php

sleep(3);

if (!file_exists("../../../../core/Themes/Aqua/")) 
{
	mkdir("../../../../core/Themes/Aqua/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Areo/")) 
{
	mkdir("../../../../core/Themes/Areo/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Default/")) 
{
	mkdir("../../../../core/Themes/Default/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Glossy/")) 
{
	mkdir("../../../../core/Themes/Glossy/", 0777, true);
}

sleep(3);

echo json_encode("../../../../core/Themes/Aqua/");

//TRUE for no check, or filename / path for check
?>