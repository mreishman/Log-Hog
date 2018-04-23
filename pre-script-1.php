<?php
if (!file_exists("../../../../core/html/")) 
{
	mkdir("../../../../core/html/", 0777, true);
}
sleep(3);
echo json_encode("../../core/html/");
//TRUE for no check, or filename / path for check
?>