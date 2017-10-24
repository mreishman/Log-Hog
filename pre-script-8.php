<?php

if (!file_exists("../../../../monitor/local/")) 
{
	mkdir("../../../../monitor/local/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/local/");

//TRUE for no check, or filename / path for check
?>