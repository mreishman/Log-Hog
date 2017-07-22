<?php

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php'); 
}
else
{
	$config = array();
}
require_once('../../core/conf/config.php'); 
require_once('loadVars.php');


	$fileName = ''.$baseUrl.'conf/config.php';

	//Don't forget to update Ajax version

	$newInfoForConfig = "
	<?php
		$"."config = array(
			'sliceSize' => ".$sliceSize.",
			'pollingRate' => ".$pollingRate.",
			'pausePoll' => '".$pausePoll."',
			'pauseOnNotFocus' => '".$pauseOnNotFocus."',
			'autoCheckUpdate' => '".$autoCheckUpdate."',
			'autoCheckDaysUpdate'	=>	'".$autoCheckDaysUpdate."',
			'developmentTabEnabled' => '".$developmentTabEnabled."',
			'enableDevBranchDownload' => '".$enableDevBranchDownload."',
			'enableSystemPrefShellOrPhp'   => '".$enableSystemPrefShellOrPhp."',
			'rightClickMenuEnable'	=> '".$rightClickMenuEnable."',
			'enableHtopLink'	=> '".$enableHtopLink."',
			'expSettingsAvail'	=> '".$expSettingsAvail."',
			'flashTitleUpdateLog'	=> '".$flashTitleUpdateLog."',
			'truncateLog' => '".$truncateLog."',
			'popupWarnings'	=>	'".$popupWarnings."',
			'pollingRateType'	=> '".$pollingRateType."',
			'logTrimOn'	=> '".$logTrimOn."',
			'logSizeLimit'	=>	".$logSizeLimit.",
			'logTrimMacBSD'	=> '".$logTrimMacBSD."',
			'baseUrlUpdate'	=> '".$baseUrlUpdate."',
			'logTrimType'	=>	'".$logTrimType."',
			'TrimSize'	=> '".$TrimSize."',
			'buffer'	=>	'".$buffer."',
			'hideEmptyLog'	=>	'".$hideEmptyLog."',
			'groupByType'	=> '".$groupByType."',
			'currentFolderColorTheme'	=> '".$currentFolderColorTheme."',
			'groupByColorEnabled'	=> '".$groupByColorEnabled."',
			'enableLogging'	=> '".$enableLogging."',
			'dontNotifyVersion'	=> '".$dontNotifyVersion."',
			'updateNoticeMeter'	=> '".$updateNoticeMeter."',
			'enablePollTimeLogging'	=> '".$enablePollTimeLogging."',
			'folderColorArrays'	=> 	array(
			".$folderColorArrays."),
			'popupSettingsArray'	=> array(
			".$popupSettingsArray."),
			'watchList' => array(
			".$watchList.")
		);
	?>";

	//Don't forget to update Ajax version

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>