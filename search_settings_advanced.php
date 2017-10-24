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
					<span class="settingsBuffer" >  Log-Hog Location:  </span> <input type="text" style="width: 400px;"  name="locationForLogHog" value="<?php echo $locationForLogHog;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/Log-Hog"; ?> ( or loghog)</p>
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
				</form>
				<?php if($configStatic['version'] != "1.0"): ?>
					<li>
						<a onclick="revertPopup();" class="link">Revert to Previous Version</a>
					</li>
				<?php endif; ?>
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