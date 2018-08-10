<?php
require_once("../core/php/commonFunctions.php");
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$baseUrlImages = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');

if($setupProcess != "step1")
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
	<?php require_once("../core/php/template/popup.php");
	echo loadCSS("../",$baseUrl, $cssVersion);
	echo loadSentryData($sendCrashInfoJS, $branchSelected);
	require_once("../core/php/customCSS.php");?>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Step 1 of <?php echo $counterSteps; ?></h1>
	</div>

	<p style="padding: 10px;">Watch List: These are the files/folder Log-Hog will track. Please enter in some of the folders you would like.</p>
	<?php
	$imageUrlModifier = "../";
	require_once('../core/php/settingsMainWatchFunctions.php');
	require_once('../core/php/template/settingsMainWatch.php');
	?>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<span id="setupButtonContinue">
			<?php if($counterSteps == 1): ?>
				<a onclick="updateStatus('finished');" class="link">Finish</a>
			<?php else: ?>
				<a onclick="updateStatus('step2');" class="link">Continue</a>
			<?php endif; ?>
		</span>
		<span id="setupButtonDisabled" style="display: none;">
			Click save to continue to next page
		</span>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<script type="text/javascript">
	
	var baseUrl = "<?php echo $baseUrlImages;?>";
	
	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page2
		location.reload();
	}
	var titleOfPage = "Welcome";
	var popupSettingsArray = JSON.parse(<?php echo json_encode($popupSettingsArray) ?>);
	var countOfWatchList = 0;
	var countOfAddedFiles = 0;
	var countOfClicks = 0;
	var locationInsert = "newRowLocationForWatchList";
	var saveVerifyImage = <?php echo json_encode(generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>

</script>
<script src="../core/js/lazyLoadImg.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/settingsWatchlist.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/settingsExt.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/loading-bar.min.js?v=<?php echo $cssVersion?>"></script>
<script src="stepsJavascript.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">
$(document).ready(function()
{
	urlModifier = "../";
	loadImgFromData("watchlistImg");
	loadWatchList();
});

</script>
</html>