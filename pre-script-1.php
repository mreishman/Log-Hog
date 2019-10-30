<?php
if (!file_exists("../../../../local/conf/"))
{
	mkdir("../../../../local/conf/", 0777, true);
}
sleep(3);
echo json_encode("../../local/conf/");
//TRUE for no check, or filename / path for check
?>