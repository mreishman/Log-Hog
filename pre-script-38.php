<?php

if (!file_exists("../../../../monitor/update/downloads/")) 
{
	mkdir("../../../../monitor/update/downloads/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/update/downloads/");

//TRUE for no check, or filename / path for check
?>