<?php
if (!file_exists("../../../../core/Themes/Space/template/")) 
{
	mkdir("../../../../core/Themes/Space/template/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Space/template/");
//TRUE for no check, or filename / path for check
?>
