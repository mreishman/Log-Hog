<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
echo json_encode(highlight_file($_POST["file"]));