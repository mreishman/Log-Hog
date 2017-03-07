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
	
	if(array_key_exists('watchList', $config))
	{
		$watchList = $config['watchList'];
	}
	else
	{
		$watchList = $defaultConfig['watchList'];
	}


	$arrayWatchList;
	$numberOfRows = count($watchList);
	$i = 0;
	foreach ($watchList as $key => $value) 
	{
		$i++;
		$arrayWatchList .= "'".$key."' => '".$value."'";
		if($i != $numberOfRows)
		{
			$arrayWatchList .= ",";
		}
	}

	$fileName = ''.$baseUrl.'conf/config.php';

	$newInfoForConfig = "
	<?php
		$"."config = array(
			'sliceSize' => ".$_POST['sliceSize'].",
			'pollingRate' => ".$_POST['pollingRate'].",
			'pausePoll' => '".$_POST['pausePoll']."',
			'pauseOnNotFocus' => '".$_POST['pauseOnNotFocus']."',
			'autoCheckUpdate' => '".$_POST['autoCheckUpdate']."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>