<?php
if (!file_exists("../../../../core/Themes/Terminal/template/")) 
{
	mkdir("../../../../core/Themes/Terminal/template/", 0777, true);
}
sleep(3);
echo json_encode("../../core/Themes/Terminal/template/");
//TRUE for no check, or filename / path for check
?>
