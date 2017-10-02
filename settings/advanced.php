<?php
require_once('../core/php/commonFunctions.php');

$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$localURL = $baseUrl;
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
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/advanced.js?v=<?php echo $cssVersion;?>"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<form id="devAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Development  
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsDevAdvanced();" id="resetChangesDevAdvancedHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
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
					<div class="selectDiv">
						<select name="developmentTabEnabled">
  							<option <?php if($developmentTabEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($developmentTabEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
			</ul>
		</div>
	</form>
	<form id="pollAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Advanced Poll Settings  
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsPollAdvanced();" id="resetChangesPollAdvancedHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
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
					<div class="selectDiv">
						<select name="pollRefreshAllBool">
	  						<option <?php if($pollRefreshAllBool == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($pollRefreshAllBool == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					Force poll refresh after 
					<input type="text" style="width: 100px;"  name="pollForceTrue" value="<?php echo $pollForceTrue;?>" > 
					skipped poll requests
					<div class="selectDiv">
						<select name="pollForceTrueBool">
	  						<option <?php if($pollForceTrueBool == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($pollForceTrueBool == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
			</ul>
		</div>
	</form>
	<form id="loggingDisplay" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Logging Information 
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsLoggingDisplay();" id="resetChangesLoggingDisplayHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
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
					<div class="selectDiv">
						<select name="enableLogging">
  							<option <?php if($enableLogging == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($enableLogging == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
					<br>
					<span style="font-size: 75%;">*<i>This will increase poll times by 2x to 4x</i></span>
				</li>
				<li>
					Poll Time Logging
					<div class="selectDiv">
						<select name="enablePollTimeLogging">
  							<option <?php if($enablePollTimeLogging == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($enablePollTimeLogging == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
			</ul>
		</div>
	</form>
	<form id="jsPhpSend" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Error / Crash Info
			<div class="settingsHeaderButtons"> 
				<a onclick="resetSettingsJsPhpSend();" id="resetChangesJsPhpSendHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('jsPhpSend');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					Send anonymous information about javascript errors/crashes:
					<div class="selectDiv">
						<select name="sendCrashInfoJS">
  							<option <?php if($sendCrashInfoJS == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($sendCrashInfoJS == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					Send anonymous information about php errors/crashes:
					<div class="selectDiv">
						<select name="sendCrashInfoPHP">
  							<option <?php if($sendCrashInfoPHP == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($sendCrashInfoPHP == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<img src="../core/img/exampleErrorJS.png" height="200px;">
			</ul>
		</div>
	</form>
	<form id="locationOtherApps" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			File Locations
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsLocationOtherApps();" id="resetChangesLocationOtherAppsHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('locationOtherApps');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Status Location:  </span> <input type="text" style="width: 400px;"  name="locationForStatus" value="<?php echo $locationForStatus;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/status"; ?></p>
				</li>
				<li>
					<span class="settingsBuffer" >  Monitor Location:  </span> <input type="text" style="width: 400px;"  name="locationForMonitor" value="<?php echo $locationForMonitor;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/monitor"; ?></p>
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
				<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post">
					<li>
						<a onclick="resetUpdateNotification();" class="link">Reset Update Notification</a> <i style="font-size: 75%;">*Could take up to 60 seconds to save.</i>
					</li>
					<input type="hidden" style="width: 400px;"  name="newestVersion" value="<?php echo $configStatic['version'];?>" > 
				</form>
				
			</ul>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script type="text/javascript">
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	function goToUrl(url)
	{
		var goToPage = !checkIfChanges();
		if(goToPage || popupSettingsArray.saveSettings == "false")
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
		refreshSettingsDevAdvanced();
		refreshSettingsPollAdvanced();
		refreshSettingsLoggingDisplay();
		refreshSettingsJsPhpSend();
		refreshSettingsLocationOtherApps();
    	setInterval(poll, 100);
	});

</script>