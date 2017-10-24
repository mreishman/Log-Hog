<?php

require_once("../core/php/commonFunctions.php");

$first = filterData(shell_exec("cat /proc/stat"),10);

sleep(1);

$second = filterData(shell_exec("cat /proc/stat"),10);

echo json_encode(array($first, $second));
?>