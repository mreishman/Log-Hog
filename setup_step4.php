<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}


if($setupProcess != "step4")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
	header('Location: ' . $url, true, 302);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
require_once('../core/php/loadVars.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<script src="../core/js/jquery.js"></script>
	<?php readfile('../core/html/popup.html') ?>	
	<style type="text/css">
		#settingsMainVars .settingsHeader{
			display: none;
		}
		li .settingsHeader{
			display: block !important;
		}
		#widthForWatchListSection{
			width: 100% !important;
		}
		#menu a, .link, .linkSmall, .context-menu
		{
			background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
		}
	</style>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
		<h1>Step 4 of <?php echo $counterSteps; ?></h1>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
	<p style="padding: 10px;">Would you also like to install Monitor?</p>
	<p style="padding: 10px;">Monitor is a htop like program that allows you to monitor system resources from the web.</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr>
	<th style="text-align: left;">
		<?php if($counterSteps < 6): ?>
			<a onclick="updateStatus('finished');" class="link">No Thanks, Continue to Log-Hog</a>
		<?php else: ?>
			<a onclick="updateStatus('step6');" class="link">No Thanks, Continue Setup</a>
		<?php endif; ?>
	</th>
	<th style="text-align: right;" >
		<?php if($counterSteps == 4): ?>
			<a onclick="updateStatus('step5');" class="link">Yes, Download!</a>
		<?php else: ?>
			<a onclick="updateStatus('step5');" class="link">Yes, Download!</a>
		<?php endif; ?>
	</th></tr></table>
	</div>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/settingsSave.php" method="post"></form>
<script type="text/javascript">

var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var urlForSendMain = '../core/php/performSettingsInstallUpdateAction.php?format=json';
var verifyFileTimer = null;
var dotsTimer = null;

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		if(statusExt == 'step6')
		{
			location.reload();
		}
		else
		{
			hidePopup();
			//download Monitor from github
			document.getElementById('innerSettingsText').innerHTML = "";
			dotsTimer = setInterval(function() {document.getElementById('innerSettingsText').innerHTML = ' .'+document.getElementById('innerSettingsText').innerHTML;}, '120');
			checkIfTopDirIsEmpty();
		}
	}

	function finishedDownload()
	{
		clearInterval(dotsTimer);
		location.reload();
	}
	
</script>
<script src="stepsJavascript.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/settingsMain.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/loghogDownloadJS.js?v=<?php echo $cssVersion?>"></script>
</html>