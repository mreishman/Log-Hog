<?php

if (!file_exists("../../../../monitor/")) 
{
	mkdir("../../../../monitor/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/");

//TRUE for no check, or filename / path for check
?>