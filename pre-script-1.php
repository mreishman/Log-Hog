<?php
if (!file_exists("../../../../core/Themes/Ocean/")) 
{
	mkdir("../../../../core/Themes/Ocean/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Ocean/");
//TRUE for no check, or filename / path for check
?>
