<?php
if (!file_exists("../../../../core/Themes/Terminal/img/")) 
{
	mkdir("../../../../core/Themes/Terminal/img/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Terminal/img/");
//TRUE for no check, or filename / path for check
?>
