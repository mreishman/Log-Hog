<?php

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


$time_start = microtime_float();

require_once('settingsInstallUpdate.php'); 
require_once('updateProgressFile.php');

$action = $_POST['actionVar'];
$requiredVars = $_POST['requiredVars'];
$action($requiredVars);

$time_end = microtime_float();
$time = $time_end - $time_start;
//update log
updateMainProgressLogFile($time);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

?>
