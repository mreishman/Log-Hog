<?php

if (!file_exists("../../../../monitor/core/html/")) 
{
	mkdir("../../../../monitor/core/html/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/html/");

//TRUE for no check, or filename / path for check
?>