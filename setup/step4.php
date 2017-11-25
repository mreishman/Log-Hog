<?php
require_once("../core/php/commonFunctions.php");
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$baseUrlImages = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');

$monitorInstalled = is_file("../monitor/index.php");

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
	<script src="../core/js/jquery.js"></script>
	<?php readfile('../core/html/popup.html');
	echo loadCSS($baseUrl, $cssVersion);
	require_once("../core/php/customCSS.php");?>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
		<h1>Step 4 of <?php echo $counterSteps; ?></h1>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
		<?php if($monitorInstalled):?>
			<p style="padding: 10px;">You currently have monitor installed</p>
			<p style="padding: 10px;">Would you like to remove monitor?</p>
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
					<a onclick="updateStatus('step5-1');" class="link">Yes, Remove :c</a>
				<?php else: ?>
					<a onclick="updateStatus('step5-1');" class="link">Yes, Remove :c</a>
				<?php endif; ?>
			</th></tr></table>
		<?php else: ?>
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
		<?php endif;?>
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
			document.getElementById('innerSettingsText').innerHTML = "";
			dotsTimer = setInterval(function() {document.getElementById('innerSettingsText').innerHTML = ' .'+document.getElementById('innerSettingsText').innerHTML;}, '120');
			if(statusExt == 'step5')
			{
				//download Monitor from github
				checkIfTopDirIsEmpty();
			}
			else
			{
				removeFilesFromToppFolder(true);
			}
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