<?php

if (!file_exists("../../../../monitor/local/default/template/")) 
{
	mkdir("../../../../monitor/local/default/template/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/local/default/template/");

//TRUE for no check, or filename / path for check
?>