<?php

if (!file_exists("../../../../monitor/local/default/conf/")) 
{
	mkdir("../../../../monitor/local/default/conf/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/local/default/conf/");

//TRUE for no check, or filename / path for check
?>