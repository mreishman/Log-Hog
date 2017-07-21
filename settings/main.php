
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
 	var arrayOfValuesToCheckBeforeSave;
 	var arrayOfValuesToCheckBeforeSaveMenu;

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
			goToPage = checkArrayOfArraysToMatch(arrayOfValuesToCheckBeforeSave);
			if(goToPage)
			{
				goToPage = checkForChangesWatchList();
			}
			if(goToPage)
			{
				goToPage = checkForChangesMenuSettings();
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

	function checkArrayOfArraysToMatch(arrayOfArrays)
	{
		var returnValue = true;
		for (var i = arrayOfArrays.length - 1; i >= 0; i--) 
		{
			if(arrayOfArrays[i][0].value != arrayOfArrays[i][1])
			{
				returnValue = false;
				break;
			}
		}
		return returnValue;
	}

	function checkForChangesWatchList()
	{
		var fileCount = 1;
		var returnValue = true;
		$.each( fileArray, function( key, value ) 
		{
			if(returnValue)
			{
				if(document.getElementsByName("watchListKey"+fileCount)[0].value != key)
				{
					returnValue = false;
				}
				else if (document.getElementsByName("watchListItem"+fileCount)[0].value != value)
				{
					returnValue =  false;
				}
				fileCount++;
			}
		});
		return returnValue;
	}

	function checkForChangesWatchListPoll()
	{
		if(!checkForChangesWatchList())
		{
			//show reset button
			document.getElementById('resetChangesSettingsHeaderButton').style.display = "inline-block";
			return true;
		}
		else
		{
			//hide reset button
			document.getElementById('resetChangesSettingsHeaderButton').style.display = "none";
			return false;
		}
	}

	function checkForChangesMainSettings()
	{
		if(!checkArrayOfArraysToMatch(arrayOfValuesToCheckBeforeSave))
		{
			//show reset button
			document.getElementById('resetChangesMainSettingsHeaderButton').style.display = "inline-block";
			return true;
		}
		else
		{
			//hide reset button
			document.getElementById('resetChangesMainSettingsHeaderButton').style.display = "none";
			return false;
		}
	}

	function checkForChangesMenuSettings()
	{
		if(!checkArrayOfArraysToMatch(arrayOfValuesToCheckBeforeSaveMenu))
		{
			//show reset button
			document.getElementById('resetChangesMenuSettingsHeaderButton').style.display = "inline-block";
			return true;
		}
		else
		{
			//hide reset button
			document.getElementById('resetChangesMenuSettingsHeaderButton').style.display = "none";
			return false;
		}
	}

	function poll()
	{
		var change = checkForChangesWatchListPoll();
		var change2 = checkForChangesMainSettings();
		var change3 = checkForChangesMenuSettings();
		if(change || change2 || change3)
		{
			document.getElementById('mainLink').innerHTML = "Main*";
		}
		else
		{
			document.getElementById('mainLink').innerHTML = "Main";
		}
	}

	$( document ).ready(function() 
	{
		refreshData();
    	setInterval(poll, 100);
	});

	function refreshData()
	{
		arrayOfValuesToCheckBeforeSave = Array(
				Array((document.getElementsByName("sliceSize")[0]), "<?php echo $sliceSize;?>"),
				Array((document.getElementsByName("pollingRate")[0]),"<?php echo $pollingRate;?>"),
				Array((document.getElementsByName("pausePoll")[0]),"<?php echo $pausePoll;?>"),
				Array((document.getElementsByName("pauseOnNotFocus")[0]),"<?php echo $pauseOnNotFocus;?>"),
				Array((document.getElementsByName("autoCheckUpdate")[0]),"<?php echo $autoCheckUpdate;?>"),
				Array((document.getElementsByName("truncateLog")[0]),"<?php echo $truncateLog;?>"),
				Array((document.getElementsByName("popupWarnings")[0]),"<?php echo $popupWarnings;?>"),
				Array((document.getElementsByName("flashTitleUpdateLog")[0]),"<?php echo $flashTitleUpdateLog;?>"),
				Array((document.getElementById("numberOfRows")),"<?php echo $folderCount;?>"),
				Array((document.getElementsByName("saveSettings")[0]),popupSettingsArray.saveSettings),
				Array((document.getElementsByName("blankFolder")[0]),popupSettingsArray.blankFolder),
				Array((document.getElementsByName("removeFolder")[0]),popupSettingsArray.removeFolder),
				Array((document.getElementsByName("pollingRateType")[0]),"<?php echo $pollingRateType;?>"),
				Array((document.getElementsByName("autoCheckDaysUpdate")[0]),"<?php echo $autoCheckDaysUpdate;?>"),
				Array((document.getElementsByName("updateNoticeMeter")[0]),"<?php echo $updateNoticeMeter;?>"),
				Array((document.getElementsByName("logTrimOn")[0]),"<?php echo $logTrimOn;?>"),
				Array((document.getElementsByName("rightClickMenuEnable")[0]),"<?php echo $rightClickMenuEnable;?>"));

		arrayOfValuesToCheckBeforeSaveMenu = Array(
				Array((document.getElementsByName("hideEmptyLog")[0]), "<?php echo $hideEmptyLog;?>"),
				Array((document.getElementsByName("groupByType")[0]), "<?php echo $groupByType;?>"),
				Array((document.getElementsByName("groupByColorEnabled")[0]),"<?php echo $groupByColorEnabled;?>"));

	}

	function resetSettingsArrayList(arrayOfArrays)
	{
		for (var i = arrayOfArrays.length - 1; i >= 0; i--) 
		{
			arrayOfArrays[i][0].value = arrayOfArrays[i][1];
		}
	}

	function resetWatchListVars()
	{
		var fileCount = 1;
		$.each( fileArray, function( key, value ) 
		{
			document.getElementsByName("watchListKey"+fileCount)[0].value = key;
			document.getElementsByName("watchListItem"+fileCount)[0].value = value;
			fileCount++;
		});
	}

	function resetSettingsMainVar()
	{
		resetSettingsArrayList(arrayOfValuesToCheckBeforeSave);
	}

	function resetSettingsMenuVar()
	{
		resetSettingsArrayList(arrayOfValuesToCheckBeforeSaveMenu);
	}
	

	</script>
<?php endif; ?>