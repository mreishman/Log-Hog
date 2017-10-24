<?php

if (!file_exists("../../../../monitor/settings/")) 
{
	mkdir("../../../../monitor/settings/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/settings/");

//TRUE for no check, or filename / path for check
?>