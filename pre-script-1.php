<?php
if (!file_exists("../../../../local/Themes/"))
{
	mkdir("../../../../local/Themes/", 0777, true);
}
sleep(3);
echo json_encode("../../local/Themes/");
//TRUE for no check, or filename / path for check
?>