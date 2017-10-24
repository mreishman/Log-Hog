<?php

if (!file_exists("../../../../monitor/local/default/")) 
{
	mkdir("../../../../monitor/local/default/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/local/default/");

//TRUE for no check, or filename / path for check
?>