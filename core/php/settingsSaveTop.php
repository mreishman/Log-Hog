<?php

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

if(file_exists($baseUrl.'conf/topConfig.php'))
{
	require_once($baseUrl.'conf/topConfig.php'); 
}
else
{
	$config = array();
}
require_once('../../core/conf/configTop.php'); 
require_once('loadVarsTop.php');


	$fileName = ''.$baseUrl.'conf/topConfig.php';

	//Don't forget to update Ajax version

	$newInfoForConfig = "
	<?php
		$"."topConfig = array(
			'pollingRateOverviewMain' => '".$pollingRateOverviewMain."',
			'pollingRateOverviewSlow' => '".$pollingRateOverviewSlow."',
			'pollingRateOverviewMainType'	=> '".$pollingRateOverviewMainType."',
			'pollingRateOverviewSlowType'	=> '".$pollingRateOverviewSlowType."'
			);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>