<?php
if (!file_exists("../../../../session/"))
{
	mkdir("../../../../session/", 0777, true);
}
sleep(3);
echo json_encode("../../session/");
//TRUE for no check, or filename / path for check
?>
