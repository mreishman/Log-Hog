<?php

if (!file_exists("../../../../monitor/core/php/template/")) 
{
	mkdir("../../../../monitor/core/php/template/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/php/template/");

//TRUE for no check, or filename / path for check
?>