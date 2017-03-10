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
	if(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}



	$arrayWatchList = "";
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
			'sliceSize' => ".$sliceSize.",
			'pollingRate' => ".$pollingRate.",
			'pausePoll' => '".$pausePoll."',
			'pauseOnNotFocus' => '".$pauseOnNotFocus."',
			'autoCheckUpdate' => '".$autoCheckUpdate."',
			'developmentTabEnabled' => '".$_POST['developmentTabEnabled']."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>