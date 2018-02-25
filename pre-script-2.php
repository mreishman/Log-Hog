<?php
if (!file_exists("../../../../core/Themes/Steampunk/img/")) 
{
	mkdir("../../../../core/Themes/Steampunk/img/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Steampunk/img/");
//TRUE for no check, or filename / path for check
?>
