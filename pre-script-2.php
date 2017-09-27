<?php

sleep(3);

if (!file_exists("../../../../local/default/img/")) 
{
	mkdir("../../../../local/default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../../../local/default/img/");

//TRUE for no check, or filename / path for check
?>
