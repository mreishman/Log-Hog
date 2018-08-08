<?php
$fileName = $_POST['file'];
require_once("../../".$fileName);
echo json_encode($logData);