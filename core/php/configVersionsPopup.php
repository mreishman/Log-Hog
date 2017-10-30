<?php

$returnData = array(
	'backupCopiesPresent' => false, 
);

require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
if(file_exists($baseUrl."conf/config1.php"))
{
	/* build popup with files*/
	$returnData['backupCopiesPresent'] = true;
}

echo json_encode($returnData);