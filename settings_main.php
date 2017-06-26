
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
				<select id="logTrimOn" name="logTrimOn">
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
									<option <?php if($logTrimType == 'lines'){echo "selected";} ?> value="lines">Line Count</option>
									<option <?php if($logTrimType == 'size'){echo "selected";} ?> value="size">File Size</option>
							</select>
						


						: </span> 
							<input type="text" name="logSizeLimit" value="<?php echo $logSizeLimit;?>" > 
							<span id="logTrimTypeText" >
								
							</span>
						</li>

						<li id="LiForlogTrimMacBSD">
							<span class="settingsBuffer" > Use Mac/Free BSD Command: </span>  
							<select name="logTrimMacBSD">
									<option <?php if($logTrimMacBSD == 'true'){echo "selected";} ?> value="true">True</option>
									<option <?php if($logTrimMacBSD == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>

						<li id="LiForlogTrimSize" <?php if($logTrimType != 'size'){echo "style='display:none;'";} ?> >
							<span class="settingsBuffer" > Size is measured in: </span>  
							<select name="TrimSize">
									<option <?php if($TrimSize == 'KB'){echo "selected";} ?> value="KB">KB</option>
									<option <?php if($TrimSize == 'K'){echo "selected";} ?> value="K">K</option>
									<option <?php if($TrimSize == 'MB'){echo "selected";} ?> value="MB">MB</option>
									<option <?php if($TrimSize == 'M'){echo "selected";} ?> value="M">M</option>
							</select>
							<br>
							<span style="font-size: 75%;">*<i>This will increase poll times by 2x to 4x</i></span>
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
						<li>
						<span class="settingsBuffer" > Notify Updates on: </span> 
							<select id="updateNoticeMeter" name="updateNoticeMeter">
		  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
		  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
							</select>
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
			<li>
				<span class="settingsBuffer" > Right Click Menu: </span> 
					<select name="rightClickMenuEnable">
  						<option <?php if($rightClickMenuEnable == 'true'){echo "selected";} ?> value="true">Enabled</option>
  						<option <?php if($rightClickMenuEnable == 'false'){echo "selected";} ?> value="false">Disabled</option>
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
				if(file_exists($key))
				{
					$perms  =  fileperms($key); 

					switch ($perms & 0xF000) {
					    case 0xC000: // socket
					        $info = 's';
					        break;
					    case 0xA000: // symbolic link
					        $info = 'l';
					        break;
					    case 0x8000: // regular
					        $info = 'f';
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
				}
				else
				{
					$info = "u---------";
				}

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
					<li>
						f - file &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
						d - directory &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
						u - unknown / file not found &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
						r - readable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
						w - writeable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
						x - executable
					</li>
				</ul>
			</li>
		</ul>
		</div>
		<div id="hidden" style="display: none">
			<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
		</div>	
		</form>
		<?php $folderCount = $i; ?>
		<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
		Menu Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				<span class="settingsBuffer" > Hide logs that are empty: </span>
				<select name="hideEmptyLog">
						<option <?php if($hideEmptyLog == 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($hideEmptyLog == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
				
			</li>
			<li>
				<span class="settingsBuffer" > Group 
					<select name="groupByType">
						<option <?php if($groupByType == 'folder'){echo "selected";} ?> value="folder">Folders</option>
						<option <?php if($groupByType == 'file'){echo "selected";} ?> value="file">Files</option>
					</select>
				 by color: </span>
				<select name="groupByColorEnabled">
						<option <?php if($groupByColorEnabled == 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($groupByColorEnabled == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
				<div class="settingsHeader">
					Folder Group Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
						<?php $i = 0; foreach ($folderColorArrays as $key => $value): $i++ ?>
							<li>
								<span class="settingsBuffer" > <input type="radio" name="currentFolderColorTheme" <?php if ($key == $currentFolderColorTheme){echo "checked='checked'";}?> value="<?php echo $key; ?>"> <?php echo $key; ?>: </span>  <input style="display: none;" type="text" name="folderColorThemeNameForPost<?php echo $i;?>" value="<?php echo $key; ?>" >
								<?php $j = 0; foreach ($value as $key2 => $value2): $j++;?>
									<div class="colorSelectorDiv" style="background-color: <?php echo $value2; ?>" >
										<!-- <div class="inner-triangle" ></div> -->
									</div>
									<input style="width: 100px; display: none;" type="text" name="folderColorValue<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2; ?>" >
								<?php endforeach; ?>
							</li>
						<?php endforeach; ?>
						<input style="display: none;" type="text" name="folderThemeCount" value="<?php echo $i; ?>">
					</ul>
					</div>
				</div>
			</li>
		</ul>
		</div>
		</form>
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
		if(popupSettingsArray.saveSettings != "false")
		{
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
