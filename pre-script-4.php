<?php

sleep(3);

if (!file_exists("../../../../core/Themes/Aqua/img/")) 
{
	mkdir("../../../../core/Themes/Aqua/img/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Areo/img/")) 
{
	mkdir("../../../../core/Themes/Areo/img/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Default/img/")) 
{
	mkdir("../../../../core/Themes/Default/img/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Glossy/img/")) 
{
	mkdir("../../../../core/Themes/Glossy/img/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Aqua/template/")) 
{
	mkdir("../../../../core/Themes/Aqua/template/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Areo/template/")) 
{
	mkdir("../../../../core/Themes/Areo/template/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Default/template/")) 
{
	mkdir("../../../../core/Themes/Default/template/", 0777, true);
}

if (!file_exists("../../../../core/Themes/Glossy/template/")) 
{
	mkdir("../../../../core/Themes/Glossy/template/", 0777, true);
}

sleep(3);

echo json_encode("../../core/Themes/Aqua/img/");

//TRUE for no check, or filename / path for check
?>
