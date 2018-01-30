<?php
if (!file_exists("../../../../core/Themes/Ocean/template/")) 
{
	mkdir("../../../../core/Themes/Ocean/template/", 0777, true);
}
sleep(3);
echo json_encode("../../../../core/Themes/Ocean/template/");
//TRUE for no check, or filename / path for check
?>