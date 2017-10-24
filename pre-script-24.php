<?php

if (!file_exists("../../../../monitor/core/php/")) 
{
	mkdir("../../../../monitor/core/php/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/php/");

//TRUE for no check, or filename / path for check
?>