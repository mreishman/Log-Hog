<?php
require_once("../core/php/commonFunctions.php");
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$baseUrlImages = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');
require_once('../core/php/commonFunctions.php');

if($setupProcess != "step5")
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
require_once('../core/php/loadVars.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<script src="../core/js/jquery.js"></script>
	<?php require_once("../core/php/template/popup.php");
	echo loadCSS("../",$baseUrl, $cssVersion);
	echo loadSentryData($sendCrashInfoJS, $branchSelected);
	require_once("../core/php/customCSS.php");?>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Step 5 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Would you like to install a plugin?:</p>
		<?php require_once("../core/php/template/innerAddon.php"); ?>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<?php if($counterSteps == 5): ?>
			<a onclick="updateStatus('finished');" class="link">Finish</a>
		<?php else: ?>
			<a onclick="updateStatus('step6');" class="link">Continue</a>
		<?php endif; ?>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<script type="text/javascript">
	var urlForSendMain = "../core/php/performSettingsInstallUpdateAction.php?format=json";
	var baseUrl = "<?php echo $baseUrlImages;?>";

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page1
		location.reload();
	}
	
	var titleOfPage = "Welcome";

	var saveVerifyImage = <?php echo json_encode(generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>
</script>
<script src="../core/js/settings.js?v=<?php echo $jsVersion?>"></script>
<script src="stepsJavascript.js?v=<?php echo $jsVersion?>"></script>
<script src="core/js/loghogDownloadJS.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	loadImgFromData("mainMenuImage");
});

</script>
</html>