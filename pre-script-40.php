<?php

if (!file_exists("../../../../monitor/update/downloads/updateFiles/")) 
{
	mkdir("../../../../monitor/update/downloads/updateFiles/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/update/downloads/updateFiles/");

//TRUE for no check, or filename / path for check
?>