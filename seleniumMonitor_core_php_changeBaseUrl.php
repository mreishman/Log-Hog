<?php

require_once('../../core/php/commonFunctions.php');

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');
require_once('../../core/php/loadVars.php');

$string = "<?php 
	$"."staticBaseUrl = '".$_POST['baseUrl']."';";

$fileName = $locationOfBaseUrl."baseUrl.php";
file_put_contents($fileName, $string);

echo json_encode(true);