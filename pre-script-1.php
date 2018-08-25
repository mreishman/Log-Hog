<?php
if (!file_exists("../../../../core/Themes/Space/")) 
{
	mkdir("../../../../core/Themes/Space/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Space/");
//TRUE for no check, or filename / path for check
?>
