<?php
$processNumber = $_POST['processNumber'];
if(strlen(escapeshellarg($processNumber)) < 500)
{
	$function = "kill -9 ".escapeshellarg($processNumber);
	shell_exec($function);
}
else
{
	echo json_encode("error");
}

?>