<?php

if (!file_exists("../../../../monitor/core/template/")) 
{
	mkdir("../../../../monitor/core/template/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/template/");

//TRUE for no check, or filename / path for check
?>