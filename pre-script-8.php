<?php

if (!file_exists("../../../../seleniumMonitor/view/")) 
{
	mkdir("../../../../seleniumMonitor/view/", 0777, true);
}

sleep(3);

echo json_encode("../../seleniumMonitor/view/");

//TRUE for no check, or filename / path for check
?>