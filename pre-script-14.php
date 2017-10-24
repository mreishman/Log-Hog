<?php

if (!file_exists("../../../../monitor/update/")) 
{
	mkdir("../../../../monitor/update/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/update/");

//TRUE for no check, or filename / path for check
?>