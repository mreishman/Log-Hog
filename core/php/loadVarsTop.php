<?php

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

//check for previous update, if failed

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";        
}

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
if(file_exists($baseUrl.'conf/topConfig.php'))
{
	require_once($baseUrl.'conf/topConfig.php'); 
}
else
{
	$topConfig = array();
}
require_once($varToIndexDir.'core/conf/configTop.php');

if(isset($_POST['pollingRateOverviewMain']))
{
	$pollingRateOverviewMain = $_POST['pollingRateOverviewMain'];
}
elseif(array_key_exists('pollingRateOverviewMain', $topConfig))
{
	$pollingRateOverviewMain = $topConfig['pollingRateOverviewMain'];
}
else
{
	$pollingRateOverviewMain = $defaultTopConfig['pollingRateOverviewMain'];
}
if(isset($_POST['pollingRateOverviewMainType']))
{
	$pollingRateOverviewMainType = $_POST['pollingRateOverviewMainType'];
}
elseif(array_key_exists('pollingRateOverviewMainType', $topConfig))
{
	$pollingRateOverviewMainType = $topConfig['pollingRateOverviewMainType'];
}
else
{
	$pollingRateOverviewMainType = $defaultTopConfig['pollingRateOverviewMainType'];
}
if(isset($_POST['pollingRateOverviewSlow']))
{
	$pollingRateOverviewSlow = $_POST['pollingRateOverviewSlow'];
}
elseif(array_key_exists('pollingRateOverviewSlow', $topConfig))
{
	$pollingRateOverviewSlow = $topConfig['pollingRateOverviewSlow'];
}
else
{
	$pollingRateOverviewSlow = $defaultTopConfig['pollingRateOverviewSlow'];
}
if(isset($_POST['pollingRateOverviewSlowType']))
{
	$pollingRateOverviewSlowType = $_POST['pollingRateOverviewSlowType'];
}
elseif(array_key_exists('pollingRateOverviewSlowType', $topConfig))
{
	$pollingRateOverviewSlowType = $topConfig['pollingRateOverviewSlowType'];
}
else
{
	$pollingRateOverviewSlowType = $defaultTopConfig['pollingRateOverviewSlowType'];
}

?>