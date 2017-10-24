<?php

if (!file_exists("../../../../monitor/core/")) 
{
	mkdir("../../../../monitor/core/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/");

//TRUE for no check, or filename / path for check
?>