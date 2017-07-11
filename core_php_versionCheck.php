<?php
require_once('../../core/php/configStatic.php');

$response = $configStatic['version'];

echo json_encode($response);

?>