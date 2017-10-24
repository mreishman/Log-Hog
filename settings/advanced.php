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
	<form id="advancedConfig" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Config
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsAdvancedConfig();" id="resetChangesAdvancedConfigHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('advancedConfig');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer"> Branch: </span>
					<div class="selectDiv">	
						<select name="branchSelected">		
							<option <?php if($branchSelected == 'default'){echo "selected";} ?> value="default" >Default</option>		
							<option <?php if($branchSelected == 'beta'){echo "selected";} ?> value="beta">Beta</option>		
							<?php if($enableDevBranchDownload == 'true'):?>		
								<option <?php if($branchSelected == 'dev'){echo "selected";} ?> value="dev">Dev</option>		
							<?php endif;?>		
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer"> Number of versions saved:</span>
					<div class="selectDiv">
						<select name="backupNumConfig">
							<?php for ($i=1; $i <= 10; $i++): ?> 
								<option <?php if($backupNumConfig === $i){echo "selected";} ?> value=<?php echo $i;?>><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
					</div>
					Enabled
					<div class="selectDiv">
						<select name="backupNumConfigEnabled">
  							<option <?php if($backupNumConfigEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($backupNumConfigEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<a class="link">View restore options for config</a>
					<span> | </span>
					<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
				</li>
			</ul>
		</div>
	</form>
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
					<span class="settingsBuffer"> Enable Development Tools:</span>
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
					<span class="settingsBuffer"> Poll refresh all data every </span>
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
					<span class="settingsBuffer"> Force poll refresh after </span>
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
					<span class="settingsBuffer"> File Info Logging </span>
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
					<span class="settingsBuffer"> Poll Time Logging </span>
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
					<span class="settingsBuffer" >  Search Location:  </span> <input type="text" style="width: 400px;"  name="locationForSearch" value="<?php echo $locationForSearch;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/search"; ?></p>
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
				<li>
					Re-do setup
					<a style="text-decoration: none;" href="../setup/step1.php" class="link">Setup</a>
				</li>
				<li>
					<a onclick="revertPopup();" class="link">Revert to Previous Version</a>
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
	<form id="resetSettings" action="../core/php/settingsSave.php" method="post">
		<select style="display: none;" name="resetConfigValuesBackToDefault">
				<option selected value="true">True</option>
		</select>
	</form>
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

	var htmlRestoreOptions = "<?php readfile('../core/html/restoreVersionOptions.html') ?>";

</script>