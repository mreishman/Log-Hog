<?php
if (!file_exists("../../../../core/Themes/Steampunk/template/")) 
{
	mkdir("../../../../core/Themes/Steampunk/template/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Steampunk/template/");
//TRUE for no check, or filename / path for check
?>
