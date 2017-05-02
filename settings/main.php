
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

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}
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
		<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
		Main Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				<span class="settingsBuffer" > Slice Size:</span>  <input type="text" name="sliceSize" value="<?php echo $sliceSize;?>" > Lines
			</li>
			<li>
				<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" >
				<select name="pollingRateType">
						<option <?php if($pollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
						<option <?php if($pollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
				</select>
			</li>
			<li>
				<span class="settingsBuffer" > Log trim:  </span>
				<select name="logTrimOn">
					<option <?php if($logTrimOn == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($logTrimOn == 'false'){echo "selected";} ?> value="false">False</option>
				</select>

				<div id="settingsLogTrimVars" <?php if($logTrimOn == 'false'){echo "style='display: none;'";}?> >

				<div class="settingsHeader">
					Log Trim Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
					
						<li>
						<span class="settingsBuffer" > Max 

						<select id="logTrimTypeToggle" name="logTrimType">
									<option <?php if($logTrimType == 'line'){echo "selected";} ?> value="lines">Line Count</option>
									<option <?php if($logTrimType == 'size'){echo "selected";} ?> value="size">File Size</option>
							</select>
						


						: </span> 
							<input type="text" name="logSizeLimit" value="<?php echo $logSizeLimit;?>" > 
							<span id="logTrimTypeText" >
								
							</span>
						</li>

						<li id="LiForlogTrimMacBSD" >
							<span class="settingsBuffer" > Use Mac/Free BSD Command: </span>  
							<select name="logTrimMacBSD">
									<option <?php if($logTrimMacBSD == 'true'){echo "selected";} ?> value="true">True</option>
									<option <?php if($logTrimMacBSD == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>

						<li id="LiForlogTrimSize" >
							<span class="settingsBuffer" > Size is measured in: </span>  
							<select name="TrimSize">
									<option <?php if($TrimSize == 'KB'){echo "selected";} ?> value="KB">KB</option>
									<option <?php if($TrimSize == 'K'){echo "selected";} ?> value="K">K</option>
									<option <?php if($TrimSize == 'MB'){echo "selected";} ?> value="MB">MB</option>
									<option <?php if($TrimSize == 'M'){echo "selected";} ?> value="M">M</option>
							</select>
						</li>

					</ul>
					</div>
				</div>


			</li>
			<li>
				<span class="settingsBuffer" > Pause Poll By Default:  </span> 
					<select name="pausePoll">
  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Pause On Not Focus: </span> 
					<select name="pauseOnNotFocus">
  						<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Auto Check Update: </span> 
					<select id="settingsSelect" name="autoCheckUpdate">
  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
					</select>

				<div id="settingsAutoCheckVars" <?php if($autoCheckUpdate == 'false'){echo "style='display: none;'";}?> >

				<div class="settingsHeader">
					Auto Check Update Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
					
						<li>
						<span class="settingsBuffer" > Check for update every: </span> 
							<input type="text" name="autoCheckDaysUpdate" value="<?php echo $autoCheckDaysUpdate;?>" >  Day(s)
						</li>

					</ul>
					</div>
				</div>

			</li>
			<li>
				<span class="settingsBuffer" > Truncate Log Button: </span> 
					<select name="truncateLog">
  						<option <?php if($truncateLog == 'true'){echo "selected";} ?> value="true">All Logs</option>
  						<option <?php if($truncateLog == 'false'){echo "selected";} ?> value="false">Current Log</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Popup Warnings: </span> 
					<select id="popupSelect"  name="popupWarnings">
  						<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
  						<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
  						<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
					</select>
				<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

				<div class="settingsHeader">
					Popup Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
					<?php foreach ($popupSettingsArray as $key => $value):?>
						<li>
						<span class="settingsBuffer" > <?php echo $key;?>: </span> 
							<select name="<?php echo $key;?>">
		  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
		  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
							</select>
						</li>
					<?php endforeach;?>
					</ul>
					</div>
				</div>
			</li>
			<li>
				<span class="settingsBuffer" > Flash title on log update: </span> 
					<select name="flashTitleUpdateLog">
  						<option <?php if($flashTitleUpdateLog == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($flashTitleUpdateLog == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
		</ul>
		</div>
		</form>
		<form onsubmit="checkWatchList()" id="settingsMainWatch" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			WatchList <button >Save Changes</button>
		</div>
		<div class="settingsDiv" >	
		<ul id="settingsUl">
			<?php 
				$i = 0;
				$triggerSaveUpdate = false;
				foreach($config['watchList'] as $key => $item): $i++;

				$perms  =  fileperms($key); 

				switch ($perms & 0xF000) {
				    case 0xC000: // socket
				        $info = 's';
				        break;
				    case 0xA000: // symbolic link
				        $info = 'l';
				        break;
				    case 0x8000: // regular
				        $info = 'r';
				        break;
				    case 0x6000: // block special
				        $info = 'b';
				        break;
				    case 0x4000: // directory
				        $info = 'd';
				        break;
				    case 0x2000: // character special
				        $info = 'c';
				        break;
				    case 0x1000: // FIFO pipe
				        $info = 'p';
				        break;
				    default: // unknown
				        $info = 'u';
				}

				// Owner
				$info .= (($perms & 0x0100) ? 'r' : '-');
				$info .= (($perms & 0x0080) ? 'w' : '-');
				$info .= (($perms & 0x0040) ?
				            (($perms & 0x0800) ? 's' : 'x' ) :
				            (($perms & 0x0800) ? 'S' : '-'));

				// Group
				$info .= (($perms & 0x0020) ? 'r' : '-');
				$info .= (($perms & 0x0010) ? 'w' : '-');
				$info .= (($perms & 0x0008) ?
				            (($perms & 0x0400) ? 's' : 'x' ) :
				            (($perms & 0x0400) ? 'S' : '-'));

				// World
				$info .= (($perms & 0x0004) ? 'r' : '-');
				$info .= (($perms & 0x0002) ? 'w' : '-');
				$info .= (($perms & 0x0001) ?
				            (($perms & 0x0200) ? 't' : 'x' ) :
				            (($perms & 0x0200) ? 'T' : '-'));





				if(strpos($item, "\\") !== false)
				{
					$item = str_replace("\\", "", $item);
					$triggerSaveUpdate = true;
				}
				?>
			<li id="rowNumber<?php echo $i; ?>" >
				File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: &nbsp; <?php echo $info; ?> &nbsp;
				<?php
				if(!file_exists($key))
				{
					echo '<img id="fileNotFoundImage'.$i.'" src="../core/img/redWarning.png" height="10px">';
				}
				?> 
 				<input style='width: <?php if(!file_exists($key)){echo "480";}else{echo "500";}?>px ' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
 				<input type='text' name='watchListItem<?php echo $i; ?>' value='<?php echo $item; ?>'>
 				<a class="link" onclick="deleteRowFunctionPopup(<?php echo $i; ?>, true, '<?php echo $key; ?>')">Remove File / Folder</a>
			</li>

		<?php endforeach; ?>
		<div id="newRowLocationForWatchList">
		</div>
		</ul>
		<ul id="settingsUl">
			<li>
				<a class="link" onclick="addRowFunction()">Add New File / Folder</a>
			</li>
			<li>
				<div class="settingsHeader">
					Key
				</div>
			</li>
			<li>
				<ul id="settingsUl">
					<li>
						<img src="../core/img/redWarning.png" height="10px"> - File / Folder not found!
					</li>
				</ul>
			</li>
		</ul>
		</div>
		<div id="hidden" style="display: none">
			<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
		</div>	
		</form>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
<?php
	if($triggerSaveUpdate)
	{
		echo "document.getElementById('settingsMainWatch').submit();";
	}
	else
	{
	?>
document.getElementById("mainLink").classList.add("active");
document.getElementById("popupSelect").addEventListener("change", showOrHidePopupSubWindow, false);
document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);
document.getElementById("logTrimTypeToggle").addEventListener("change", changeDescriptionLineSize, false);


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




function changeDescriptionLineSize()
{

	var valueForDesc = document.getElementById("logTrimTypeToggle").value;

	if (valueForDesc == "lines")
	{
		document.getElementById('logTrimTypeText').innerHTML = "Lines";
	}
	else if (valueForDesc == 'size')
	{
		document.getElementById('logTrimTypeText').innerHTML = "Size";
	}

}

function addRowFunction()
{

	countOfWatchList++;
	countOfClicks++;
	if(countOfWatchList < 10)
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link'  onclick='deleteRowFunctionPopup("+ countOfWatchList +", true,"+'"'+"File #0" + countOfWatchList+'"'+")'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	else
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link' onclick='deleteRowFunctionPopup("+ countOfWatchList +", true,"+'"'+"File #" + countOfWatchList+'"'+")'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
}

function deleteRowFunctionPopup(currentRow, decreaseCountWatchListNum, keyName = "")
{
	if(popupSettingsArray.removeFolder == "true")
	{
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this file/folder?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+","+ decreaseCountWatchListNum+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}
	else
	{
		deleteRowFunction(currentRow, decreaseCountWatchListNum);
	}
	
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(decreaseCountWatchListNum)
	{
		newValue = document.getElementById('numberOfRows').value;
		if(currentRow < newValue)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= newValue; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = "rowNumber" + i;
				var documentUpdateText = "<li id='rowNumber"+updateItoIMinusOne+"' >File #";
				var watchListKeyIdFind = "watchListKey"+i;
				var watchListItemIdFind = "watchListItem"+i;
				var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
				var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
				if(updateItoIMinusOne < 10)
				{
					documentUpdateText += "0";
				}
				documentUpdateText += updateItoIMinusOne+": ";
				var nameForId = "fileNotFoundImage" + i;
				var elementByIdPreCheck = document.getElementById(nameForId);
				if(elementByIdPreCheck !== null)
				{
					documentUpdateText += '<img id="fileNotFoundImage'+updateItoIMinusOne+'" src="../core/img/redWarning.png" height="10px">';
				}
				documentUpdateText += "<input style='width: ";
				if(elementByIdPreCheck !== null)
				{
					documentUpdateText += '480';
				}
				else
				{
					documentUpdateText += '500';
				}
				documentUpdateText += "px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				documentUpdateText += ' <a class="link" onclick="deleteRowFunctionPopup('+updateItoIMinusOne+', true,'+"'"+previousElementNumIdentifierForKey[0].value+"'"+')">Remove File / Folder</a>';
				documentUpdateText += '</li>';
				document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
			}
		}
		newValue--;
		if(countOfAddedFiles > 0)
		{
			countOfAddedFiles--;
			countOfWatchList--;
		}
		document.getElementById('numberOfRows').value = newValue;
	}

}	
function showOrHidePopupSubWindow()
{
	var valueForPopup = document.getElementById('popupSelect').value;
	if(valueForPopup == 'custom')
	{
		document.getElementById('settingsPopupVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsPopupVars').style.display = 'none';
	}
}
function showOrHideUpdateSubWindow()
{
	var valueForPopup = document.getElementById('settingsSelect').value;
	if(valueForPopup == 'true')
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'none';
	}
}
function checkWatchList()
{
	var blankValue = false;
	for (var i = 1; i <= countOfWatchList; i++) 
	{
		if(document.getElementsByName("watchListKey"+i)[0].value == "")
		{
			blankValue = true;
		}
	}
	if(blankValue && popupSettingsArray.blankFolder == "true")
	{
		showNoEmptyFolderPopup();
		event.preventDefault();
		event.returnValue = false;
		return false;
	}
	else
	{
		displayLoadingPopup();
	}
}
function showNoEmptyFolderPopup()
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Warning!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Please make sure there are no empty folders when saving the Watch List.</div><div><div class='link' onclick='hidePopup();' style='margin-left:175px; margin-top:25px;'>Okay</div></div>";
}

function goToUrl(url)
	{
		var goToPage = true
		if(document.getElementsByName("sliceSize")[0].value != "<?php echo $sliceSize;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("pollingRate")[0].value != "<?php echo $pollingRate;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("pausePoll")[0].value != "<?php echo $pausePoll;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("pauseOnNotFocus")[0].value != "<?php echo $pauseOnNotFocus;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("autoCheckUpdate")[0].value != "<?php echo $autoCheckUpdate;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("truncateLog")[0].value != "<?php echo $truncateLog;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("popupWarnings")[0].value != "<?php echo $popupWarnings;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("flashTitleUpdateLog")[0].value != "<?php echo $flashTitleUpdateLog;?>")
		{
			goToPage = false;
		}
		else if(document.getElementById("numberOfRows").value != "<?php echo $i;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("saveSettings")[0].value != popupSettingsArray.saveSettings)
		{
			goToPage = false;
		}
		else if(document.getElementsByName("blankFolder")[0].value != popupSettingsArray.blankFolder)
		{
			goToPage = false;
		}
		else if(document.getElementsByName("removeFolder")[0].value != popupSettingsArray.removeFolder)
		{
			goToPage = false;
		}
		else if(document.getElementsByName("pollingRateType")[0].value != "<?php echo $pollingRateType;?>")
		{
			goToPage = false;
		}
		else if(document.getElementsByName("autoCheckDaysUpdate")[0].value != "<?php echo $autoCheckDaysUpdate;?>")
		{
			goToPage = false;
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

		if(goToPage || popupSettingsArray.saveSettings == "false")
		{
			window.location.href = url;
		}
		else
		{
			showPopup();
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Changes not Saved!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to leave the page without saving changes?</div><div class='link' onclick='window.location.href = "+'"'+url+'"'+";' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
	}
	<?php
	}
	?>
</script>