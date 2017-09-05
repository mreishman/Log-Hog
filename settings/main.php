
<meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
<meta http-equiv="expires" content="Sat, 31 Oct 2014 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

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
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/commonFunctions.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<?php echo loadSentryData($sendCrashInfoJS); ?>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main">
		<?php require_once('../core/php/template/mainVars.php'); ?>
		<?php require_once('../core/php/template/settingsMainWatch.php'); ?>
		<?php require_once('../core/php/template/settingsMenuVars.php'); ?>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<?php if($triggerSaveUpdate): ?>
	<script type="text/javascript">
	document.getElementById('settingsMainWatch').submit();
	</script>
<?php else: ?>
	<script src="../core/js/settingsMain.js"></script>
	<script type="text/javascript">
	document.getElementById("popupSelect").addEventListener("change", showOrHidePopupSubWindow, false);
	document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);
	document.getElementById("logTrimTypeToggle").addEventListener("change", changeDescriptionLineSize, false);
	document.getElementById("logTrimOn").addEventListener("change", showOrHideLogTrimSubWindow, false);
	var mainData;
	var watchlistData;
	var menuData;
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var fileArray = JSON.parse('<?php echo json_encode($config['watchList']) ?>');
	var fileArrayKeys = Object.keys(fileArray);
	var countOfWatchList = fileArrayKeys.length;
	var countOfAddedFiles = 0;
	var countOfClicks = 0;
	var locationInsert = "newRowLocationForWatchList";
	var logTrimType = "<?php echo $logTrimType; ?>";
 	var savedInnerHtmlWatchList;
 	var savedInnerHtmlMainVars;
 	var savedInnerHtmlMenu;

 	var countOfWatchListStatic = countOfWatchList;
	var countOfAddedFilesStatic = countOfAddedFiles;
	var countOfClicksStatic = countOfClicks;
	var locationInsertStatic = locationInsert;

	if(logTrimType == 'lines')
	{
		document.getElementById('logTrimTypeText').innerHTML = "Lines";
	}
	else if (logTrimType == 'size')
	{
		document.getElementById('logTrimTypeText').innerHTML = "Size";
	}

	function goToUrl(url)
	{
		var goToPage = true
		if(popupSettingsArray.saveSettings != "false")
		{
			goToPage = !checkForChangesMainSettings();
			if(goToPage)
			{
				goToPage = !checkForChangesWatchListPoll();
				if(goToPage)
				{
					goToPage = !checkForChangesMenuSettings();
				}
			}
		}
		if(goToPage)
		{
			window.location.href = url;
		}
		else
		{
			displaySavePromptPopup(url);
		}
	}

	$( document ).ready(function() 
	{
		refreshSettingsMainVar();
		refreshSettingsMenuVar();
		refreshSettingsWatchList();
    	setInterval(poll, 100);
    	$( "#main" ).scroll(function()
    	{
			highlightTopNavDepends();
		});
	});

	</script>
<?php endif; ?>