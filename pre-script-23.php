<?php

if (!file_exists("../../../../seleniumMonitor/local/default/template/")) 
{
	mkdir("../../../../seleniumMonitor/local/default/template/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/local/default/template/");

//TRUE for no check, or filename / path for check
?>