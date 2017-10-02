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
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
require_once('../top/statusTest.php');
$withLogHog = $monitorStatus['withLogHog'];
?>
<!doctype html>
<head>
	<title>Settings | Advanced</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<form id="devAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Development  
			<div class="settingsHeaderButtons">
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('devAdvanced');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					Branch:
					<select name="branchSelected">
						<option <?php if($branchSelected == 'default'){echo "selected";} ?> value="default" >Default</option>
						<option <?php if($branchSelected == 'beta'){echo "selected";} ?> value="beta">Beta</option>
						<?php if($enableDevBranchDownload == 'true'):?>
							<option <?php if($branchSelected == 'dev'){echo "selected";} ?> value="dev">Dev</option>
						<?php endif;?>
					</select>
				</li>
				<li>
					Enable Development Tools
					<select name="developmentTabEnabled">
  						<option <?php if($developmentTabEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($developmentTabEnabled == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
			</ul>
		</div>
	</form>
	<form id="pollAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Advanced Poll Settings  
			<div class="settingsHeaderButtons">
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('devAdvanced');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					Poll refresh all data every 
					<input type="text" style="width: 100px;"  name="pollRefreshAll" value="<?php echo $pollRefreshAll;?>" > 
					poll requests
					<select name="pollRefreshAllBool">
  						<option <?php if($pollRefreshAllBool == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pollRefreshAllBool == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li>
					Force poll refresh after 
					<input type="text" style="width: 100px;"  name="pollForceTrue" value="<?php echo $pollForceTrue;?>" > 
					skipped poll requests
					<select name="pollForceTrueBool">
  						<option <?php if($pollForceTrueBool == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pollForceTrueBool == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
			</ul>
		</div>
	</form>
	<form id="loggingDisplay" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Logging Information 
			<div class="settingsHeaderButtons">
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('loggingDisplay');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					File Info Logging
						<select name="enableLogging">
  						<option <?php if($enableLogging == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($enableLogging == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					<br>
					<span style="font-size: 75%;">*<i>This will increase poll times by 2x to 4x</i></span>
				</li>
				<li>
					Poll Time Logging
						<select name="enablePollTimeLogging">
  						<option <?php if($enablePollTimeLogging == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($enablePollTimeLogging == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
				</li>
			</ul>
		</div>
	</form>
	<form id="loggingDisplay" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Error / Crash Info
			<div class="settingsHeaderButtons">
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('loggingDisplay');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					Send anonymous information about javascript errors/crashes:
						<select name="sendCrashInfoJS">
  						<option <?php if($sendCrashInfoJS == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($sendCrashInfoJS == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
				</li>
				<li>
					Send anonymous information about php errors/crashes:
						<select name="sendCrashInfoPHP">
  						<option <?php if($sendCrashInfoPHP == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($sendCrashInfoPHP == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
				</li>
				<img src="../core/img/exampleErrorJS.png" height="200px;">
			</ul>
		</div>
	</form>
	<form id="locationOtherApps" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			File Locations
			<div class="settingsHeaderButtons">
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('locationOtherApps');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<?php
			//logic for urls

			if($locationForStatus == "")
			{
				$locationForStatus = "https://" . $_SERVER['SERVER_NAME']."/status";
			}
			if($locationForMonitor == "")
			{
				$locationForMonitor = "https://" . $_SERVER['SERVER_NAME']."/monitor";
			}
			?>
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Status Location:  </span> <input type="text" style="width: 400px;"  name="locationForStatus" value="<?php echo $locationForStatus;?>" > 
				</li>
				<li>
					<span class="settingsBuffer" >  Monitor Location:  </span> <input type="text" style="width: 400px;"  name="locationForMonitor" value="<?php echo $locationForMonitor;?>" > 
				</li>
				<li>
					<span style="font-size: 75%;">*<i>Please specify full url, blank if none</i></span>
				</li>
			</ul>
		</div>
	</form>
		<div class="settingsHeader">
			Advanced
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<form id="resetSettings" action="../core/php/settingsSave.php" method="post">
					<li>
						<a onclick="resetSettingsPopup();" class="link">Reset Settings</a>
					</li>
					<li style="display: none;"  >
							<select name="resetConfigValuesBackToDefault">
	  							<option selected value="true">True</option>
							</select>
					</li>
					<?php if($withLogHog == 'true'): ?>
					<li>
						*Doesn't include monitor config settings
					</li>
					<?php endif; ?>
				</form>
				<li>
					<a onclick="revertPopup();" class="link">Revert to Previous Version</a>
				</li>
				<li>
				<?php if($withLogHog == 'true'): ?>
					<a onclick="removeLoghog();" class="link">Remove Monitor</a>
				<?php else: ?>
					<a onclick="downloadLogHog();" class="link">Download Monitor</a>
				<?php endif; ?>
				</li>
			</ul>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	function goToUrl(url)
	{
		var goToPage = true
		if(document.getElementsByName("developmentTabEnabled")[0].value != "<?php echo $developmentTabEnabled;?>")
		{
			//goToPage = false;
		}

		if(goToPage || popupSettingsArray.saveSettings == "false")
		{
			window.location.href = url;
		}
		else
		{
			displaySavePromptPopup(url);
		}
	}

	function downloadLogHog()
	{
		window.location.href = 'monitorDownload.php';
	}

	function removeLoghog()
	{
		window.location.href = 'monitorRemove.php';
	}

	function resetSettingsPopup()
	{
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Reset Settings?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to reset all settings back to defaults?</div><div class='link' onclick='submitResetSettings();' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}

	function revertPopup()
	{
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Go back to previous version?</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to revert back to a previous version? Version: <?php readfile('../core/html/restoreVersionOptions.html') ?> </div><div class='link' onclick='submitRevert();' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}

	function submitRevert()
	{
		document.getElementById('revertForm').submit();
	}

	function submitResetSettings()
	{
		document.getElementById('resetSettings').submit();
	}
</script>