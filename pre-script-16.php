<?php

if (!file_exists("../../../../monitor/core/conf/")) 
{
	mkdir("../../../../monitor/core/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/conf/");

//TRUE for no check, or filename / path for check
?>