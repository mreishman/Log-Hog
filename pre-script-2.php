<?php

sleep(3);

if (!file_exists("../../../../local/Default/img/")) 
{
	mkdir("../../../../local/Default/img/", 0777, true);
}

sleep(3);

echo json_encode("../../../../local/Default/img/");

//TRUE for no check, or filename / path for check
?>