<?php
if (!file_exists("../../../../core/Themes/Space/img/")) 
{
	mkdir("../../../../core/Themes/Space/img/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Space/img/");
//TRUE for no check, or filename / path for check
?>
