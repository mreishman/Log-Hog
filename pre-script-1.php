<?php
if (!file_exists("../../../../core/Themes/Steampunk/")) 
{
	mkdir("../../../../core/Themes/Steampunk/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Steampunk/");
//TRUE for no check, or filename / path for check
?>
