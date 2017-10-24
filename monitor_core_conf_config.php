<?php

$defaultConfig = array(
	'pollingRateOverviewMain' => 1000,
	'pollingRateOverviewSlow' => 10000,
	'configVersion'	=> 1,
	'layoutVersion'	=> 1,
	'autoCheckUpdate' => 'true',
	'autoCheckDaysUpdate'	=>	'7',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'dontNotifyVersion'	=> '0',
	'updateNoticeMeter'	=> 'every',
	'popupSettings'	=>	'all',
	'pollingRateOverviewMainType'	=> 'Milliseconds',
	'pollingRateOverviewSlowType'	=> 'Milliseconds',
	'baseUrlUpdate'	=> 'https://github.com/mreishman/monitor/archive/',
	'popupSettingsCustom'	=> array(
		'saveSettings'	=>	'true',
		'versionCheck'	=> 'true'
		),
);