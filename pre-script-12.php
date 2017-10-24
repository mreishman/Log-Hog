<?php

if (!file_exists("../../../../monitor/setup/")) 
{
	mkdir("../../../../monitor/setup/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/setup/");

//TRUE for no check, or filename / path for check
?>