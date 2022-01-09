<?php
if (!file_exists("../../../../core/php/post/"))
{
	mkdir("../../../../core/php/post/", 0777, true);
}
sleep(3);
echo json_encode("../../core/php/post/");
//TRUE for no check, or filename / path for check
?>
