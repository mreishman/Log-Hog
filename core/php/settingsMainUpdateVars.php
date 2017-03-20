<?php

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
require_once('loadVars.php');

	$fileName = ''.$baseUrl.'conf/config.php';

	$newInfoForConfig = "
	<?php
		$"."config = array(
			'sliceSize' => ".$_POST['sliceSize'].",
			'pollingRate' => ".$_POST['pollingRate'].",
			'pausePoll' => '".$_POST['pausePoll']."',
			'pauseOnNotFocus' => '".$_POST['pauseOnNotFocus']."',
			'autoCheckUpdate' => '".$_POST['autoCheckUpdate']."',
			'developmentTabEnabled' => '".$developmentTabEnabled."',
			'enableDevBranchDownload' => '".$enableDevBranchDownload."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>