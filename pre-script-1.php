<?php
if (!file_exists("../../../../core/js/formatObjects/")) 
{
	mkdir("../../../../core/js/formatObjects/", 0777, true);
}
sleep(3);
echo json_encode("../../core/js/formatObjects/");
//TRUE for no check, or filename / path for check
?>
