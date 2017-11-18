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

/* Check for backup config stuff */
$count = 1;
$showConfigBackupClear = false;
while (file_exists($baseUrl."conf/config".$count.".php"))
{
	if(!$showConfigBackupClear)
	{
		$showConfigBackupClear = true;
	}
	$count++;
}

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
				<?php echo addResetButton("advancedConfig");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('advancedConfig');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<?php if($enableDevBranchDownload == 'true'):?>
					<li>
						<span class="settingsBuffer"> Branch: </span>
						<div class="selectDiv">	
							<select name="branchSelected">		
								<option <?php if($branchSelected == 'default'){echo "selected";} ?> value="default" >Default</option>
								<option <?php if($branchSelected == 'dev'){echo "selected";} ?> value="dev">Dev</option>
							</select>
						</div>
					</li>
				<?php endif;?>	
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
					<?php if($backupNumConfigEnabled == 'true'): ?>
						<a onclick="showConfigPopup();" class="link">View restore options for config</a>
						<span> | </span>
					<?php endif; ?>
					<?php if($showConfigBackupClear): ?>
						<span id="showConfigClearButton">
							<a onclick="clearBackupFiles();" class="link">Clear (<?php echo $count;?>) Backup Config Files</a>
							<span> | </span>
						</span>
					<?php endif; ?>
					<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
				</li>
			</ul>
		</div>
	</form>
	<form id="devAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Development  
			<div class="settingsHeaderButtons">
				<?php echo addResetButton("devAdvanced");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
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
	<form id="jsPhpSend" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Error / Crash Info
			<div class="settingsHeaderButtons"> 
				<?php echo addResetButton("jsPhpSend");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
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
				<?php echo addResetButton("locationOtherApps");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('locationOtherApps');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Log-Hog Location:  </span> <input type="text" style="width: 400px;"  name="locationForStatus" value="<?php echo $locationForLogHog;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/Log-Hog"; ?></p>
				</li>
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
					<a style="text-decoration: none;" href="../setup/step1.php" class="link">Re-do Setup</a>
					<span> | </span>
					<a onclick="resetUpdateNotification();" class="link">Reset Update Notification</a>
				</li>
			</ul>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>
	<form id="resetSettings" action="../core/php/settingsSave.php" method="post">
		<select style="display: none;" name="resetConfigValuesBackToDefault">
				<option selected value="true">True</option>
		</select>
	</form>
	<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post">
		<input type="hidden" style="width: 400px;"  name="newestVersion" value="<?php echo $configStatic['version'];?>" > 
	</form>
</body>