<?php

if (!file_exists("../../../../monitor/functions/")) 
{
	mkdir("../../../../monitor/functions/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/functions/");

//TRUE for no check, or filename / path for check
?>