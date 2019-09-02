<?php
if (!file_exists("../../../../core/json/"))
{
	mkdir("../../../../core/json/", 0777, true);
}
sleep(3);
echo json_encode("../../core/json/");
//TRUE for no check, or filename / path for check
?>
