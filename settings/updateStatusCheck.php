<?php

require_once('setupProcessFile.php');

if ($_POST['currentStep'] == $setupProcess)
{
	echo json_encode(true);
}
else
{
	echo json_encode(false);
}
?>