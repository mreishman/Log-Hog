<?php
if (!file_exists("../../../../core/Themes/Terminal/")) 
{
	mkdir("../../../../core/Themes/Terminal/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Terminal/");
//TRUE for no check, or filename / path for check
?>
