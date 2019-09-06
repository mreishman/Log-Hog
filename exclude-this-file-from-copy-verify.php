<?php
if(file_exists($_POST['file_name'])) {
	echo json_encode(true);
	die();
}
echo json_encode(false);
die();