<?php
if (!file_exists("../../../../restore/php/class/"))
{
	mkdir("../../../../restore/php/class/", 0777, true);
}
sleep(3);
echo json_encode("../../restore/php/class/");
//TRUE for no check, or filename / path for check
?>
