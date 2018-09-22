<?php
if (!file_exists("../../../../tmp/")) 
{
	mkdir("../../../../tmp/", 0777, true);
}
sleep(3);
echo json_encode("../../tmp/");
//TRUE for no check, or filename / path for check
?>
