<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
require_once('../../core/php/configStatic.php');
echo json_encode($configStatic['version']);