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

	//Don't forget to update Normal version

	$newInfoForConfig = "
	<?php
		$"."config = array(
			'sliceSize' => ".$sliceSize.",
			'pollingRate' => ".$pollingRate.",
			'pausePoll' => '".$pausePoll."',
			'pollingRateOverviewMain' => '".$pollingRateOverviewMain."',
			'pollingRateOverviewSlow' => '".$pollingRateOverviewSlow."',
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
			'truncateLogButtonAll' => '".$truncateLog."',
			'popupSettings'	=>	'".$popupWarnings."',
			'pollingRateType'	=> '".$pollingRateType."',
			'pollingRateOverviewMainType'	=> '".$pollingRateOverviewMainType."',
			'pollingRateOverviewSlowType'	=> '".$pollingRateOverviewSlowType."',
			'logTrimOn'	=> '".$logTrimOn."',
			'logSizeLimit'	=>	".$logSizeLimit.",
			'logTrimMacBSD'	=> '".$logTrimMacBSD."',
			'baseUrlUpdate'	=> '".$baseUrlUpdate."',
			'logTrimType'	=>	'".$logTrimType."',
			'TrimSize'	=> '".$TrimSize."',
			'hideEmptyLog'	=>	'".$hideEmptyLog."',
			'groupByType'	=> '".$groupByType."',
			'currentFolderColorTheme'	=> '".$currentFolderColorTheme."',
			'groupByColorEnabled'	=> '".$groupByColorEnabled."',
			'enableLogging'	=> '".$enableLogging."',
			'dontNotifyVersion'	=> '".$dontNotifyVersion."',
			'updateNoticeMeter'	=> '".$updateNoticeMeter."',
			'enablePollTimeLogging'	=> '".$enablePollTimeLogging."',
			'folderColorArrays'	=> 	array(
			".$folderColorArraysSave."),
			'popupSettingsCustom'	=> array(
			".$popupSettingsArraySave."),
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	//Don't forget to update Normal version

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>