
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
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
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

	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var fileArray = JSON.parse('<?php echo json_encode($config['watchList']) ?>');
	var countOfWatchList = <?php echo $i; ?>;
	var countOfAddedFiles = 0;
	var countOfClicks = 0;
	var locationInsert = "newRowLocationForWatchList";
	var logTrimType = "<?php echo $logTrimType; ?>";
 
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
			var arrayOfValuesToCheckBeforeSave = Array(
				Array((document.getElementsByName("sliceSize")[0].value), "<?php echo $sliceSize;?>"),
				Array((document.getElementsByName("pollingRate")[0].value),"<?php echo $pollingRate;?>"),
				Array((document.getElementsByName("pausePoll")[0].value),"<?php echo $pausePoll;?>"),
				Array((document.getElementsByName("pauseOnNotFocus")[0].value),"<?php echo $pauseOnNotFocus;?>"),
				Array((document.getElementsByName("autoCheckUpdate")[0].value),"<?php echo $autoCheckUpdate;?>"),
				Array((document.getElementsByName("truncateLog")[0].value),"<?php echo $truncateLog;?>"),
				Array((document.getElementsByName("popupWarnings")[0].value),"<?php echo $popupWarnings;?>"),
				Array((document.getElementsByName("flashTitleUpdateLog")[0].value),"<?php echo $flashTitleUpdateLog;?>"),
				Array((document.getElementById("numberOfRows").value),"<?php echo $folderCount;?>"),
				Array((document.getElementsByName("saveSettings")[0].value),popupSettingsArray.saveSettings),
				Array((document.getElementsByName("blankFolder")[0].value),popupSettingsArray.blankFolder),
				Array((document.getElementsByName("removeFolder")[0].value),popupSettingsArray.removeFolder),
				Array((document.getElementsByName("pollingRateType")[0].value),"<?php echo $pollingRateType;?>"),
				Array((document.getElementsByName("autoCheckDaysUpdate")[0].value),"<?php echo $autoCheckDaysUpdate;?>"));
			for (var i = arrayOfValuesToCheckBeforeSave.length - 1; i >= 0; i--) 
			{
				if(arrayOfValuesToCheckBeforeSave[i][0] != arrayOfValuesToCheckBeforeSave[i][1])
				{
					goToPage = false;
					break;
				}
			}	
			if(goToPage)
			{
				var fileCount = 1;
				$.each( fileArray, function( key, value ) 
				{
					if(goToPage)
					{
						if(document.getElementsByName("watchListKey"+fileCount)[0].value != key)
						{
							goToPage = false;
						}
						else if (document.getElementsByName("watchListItem"+fileCount)[0].value != value)
						{
							goToPage = false;
						}
						fileCount++;
					}
				});
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
	</script>
<?php endif; ?>