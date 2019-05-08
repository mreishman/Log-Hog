<?php
if (!file_exists("../../../../core/php/class/"))
{
	mkdir("../../../../core/php/class/", 0777, true);
}
sleep(3);
echo json_encode("../../core/php/class/");
//TRUE for no check, or filename / path for check
?>
