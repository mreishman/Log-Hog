<?php

require_once("../core/php/commonFunctions.php");

function filterProcNetDev($data)
{
	$data = explode("carrier compressed", $data);
	$data =  $data[1];
	$data = substr($data, 5);
	return $data;
}

$first = (filterData(filterProcNetDev(shell_exec(" cat /proc/net/dev")),16));

sleep(1);

$second = (filterData(filterProcNetDev(shell_exec(" cat /proc/net/dev")),16));

echo json_encode(array($first, $second));
?>