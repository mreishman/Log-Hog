<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
require_once('../../core/php/updateProgressFile.php');
$returnBool = false;
if($updateProgress['percent'] === 100)
{
	$returnBool = true;
}
echo json_encode($returnBool);