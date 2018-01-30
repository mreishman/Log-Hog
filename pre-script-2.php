<?php
if (!file_exists("../../../../core/Themes/Ocean/img/")) 
{
	mkdir("../../../../core/Themes/Ocean/img/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Ocean/img/");
//TRUE for no check, or filename / path for check
?>
