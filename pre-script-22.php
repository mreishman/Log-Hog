<?php

if (!file_exists("../../../../monitor/core/js/")) 
{
	mkdir("../../../../monitor/core/js/", 0777, true);
}

sleep(3);

echo json_encode("../../monitor/core/js/");

//TRUE for no check, or filename / path for check
?>