<?php
$ipAddressSend = $_POST["ip"];
if(strpos($ipAddressSend, "5555") !== false)
{
	$ipAddressSend = str_replace("5555", "", $ipAddressSend);
}
$return = null;
try 
{
	$return = 	@file_get_contents($ipAddressSend."3000");
} catch (Exception $e) {
	
}
echo json_encode($return);