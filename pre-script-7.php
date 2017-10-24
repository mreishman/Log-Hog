<?php

if (!file_exists("../../../../search/settings/")) 
{
	mkdir("../../../../search/settings/", 0777, true);
}

sleep(3);

echo json_encode("../../search/settings/");

//TRUE for no check, or filename / path for check
?>