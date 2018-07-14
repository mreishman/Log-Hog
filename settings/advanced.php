<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

/* Check for backup config stuff */
$countConfig = 1;
$showConfigBackupClear = false;
while (file_exists($baseUrl."conf/config".$countConfig.".php"))
{
	if(!$showConfigBackupClear)
	{
		$showConfigBackupClear = true;
	}
	$countConfig++;
}
$countConfig--;
?>
<!doctype html>
<head>
	<title>Settings | Advanced</title>
	<?php echo loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/advanced.js?v=<?php echo $cssVersion;?>"></script>
	<script src="../core/js/resetSettingsJs.js?v=<?php echo $cssVersion;?>"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<form id="advancedConfig">
		<div class="settingsHeader">
			Config
			<div class="settingsHeaderButtons">
				<?php echo addResetButton("advancedConfig"); ?>
				<a class="linkSmall" onclick="saveAndVerifyMain('advancedConfig');" >Save Changes</a>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul class="settingsUl">
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
					<span class="settingsBuffer"> Enable Development Tools:</span>
					<div class="selectDiv">
						<select name="developmentTabEnabled">
  							<option <?php if($developmentTabEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($developmentTabEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer" > Enable Themes: </span>
					<div class="selectDiv">
						<select name="themesEnabled">
							<option <?php if($themesEnabled == 'true'){echo "selected";} ?> value="true">True</option>
							<option <?php if($themesEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer" > Enable Multi-Log: </span>
					<div class="selectDiv">
						<select name="enableMultiLog">
							<option <?php if($enableMultiLog == 'true'){echo "selected";} ?> value="true">True</option>
							<option <?php if($enableMultiLog == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer" > Right Click Menu Enabled: </span>
					<div class="selectDiv">
						<select name="rightClickMenuEnable">
							<option <?php if($rightClickMenuEnable == 'true'){echo "selected";} ?> value="true">True</option>
							<option <?php if($rightClickMenuEnable == 'false'){echo "selected";} ?> value="false">False</option>
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
					<?php if($backupNumConfigEnabled == 'true'): ?>
						<a onclick="showConfigPopup();" class="link">View restore options for config</a>
						<span> | </span>
					<?php endif; ?>
					<?php if($showConfigBackupClear): ?>
						<span id="showConfigClearButton">
							<a onclick="clearBackupFiles();" class="link">Clear (<?php echo $countConfig;?>) Backup Config Files</a>
							<span> | </span>
						</span>
					<?php endif; ?>
					<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
				</li>
				<li>
					<span class="settingsBuffer"> Save verification number:</span>
					<div class="selectDiv">
						<select name="successVerifyNum">
							<?php for ($i=1; $i <= 5; $i++): ?> 
								<option <?php if($successVerifyNum === $i){echo "selected";} ?> value=<?php echo $i;?>><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
					</div>
					<br>
					<span style="font-size: 75%;">
						<?php echo generateImage(
							$arrayOfImages["info"],
							array(
								"style"			=>	"margin-bottom: -4px;",
								"height"		=>	"20px",
								"srcModifier"	=>	"../"
							)
						); ?>
						<i>This is for platforms where saving files might not be in sync with containers. Increasing from one will make saves take longer, but it will be more accurate if there is that sync delay</i></span>
				</li>
			</ul>
		</div>
	</form>
	<form id="loggingDisplay">
		<div class="settingsHeader">
			Logging Information
			<div class="settingsHeaderButtons">
				<?php echo addResetButton("loggingDisplay");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('loggingDisplay');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul class="settingsUl">
				<li>
					<span class="settingsBuffer"> File Info Logging </span>
					<div class="selectDiv">
						<select name="enableLogging">
  							<option <?php if($enableLogging == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($enableLogging == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
					<br>
					<span style="font-size: 75%;">
						<?php echo generateImage(
							$arrayOfImages["info"],
							array(
								"style"			=>	"margin-bottom: -4px;",
								"height"		=>	"20px",
								"srcModifier"	=>	"../"
							)
						); ?>
						<i>This will increase poll times</i></span>
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
				<li>
					Send anonymous information about Log-Hog specific javascript errors:
					<div class="selectDiv">
						<select name="sendCrashInfoJS">
  							<option <?php if($sendCrashInfoJS == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($sendCrashInfoJS == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li style="display: none;" >
					Send anonymous information about Log-Hog specific php errors:
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
	<form id="locationOtherApps">
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
			<ul class="settingsUl">
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
					<span class="settingsBuffer" >  Selenium Monitor Location:  </span> <input type="text" style="width: 400px;"  name="locationForSeleniumMonitor" value="<?php echo $locationForSeleniumMonitor;?>" > 
					<br>
					<p>Default = <?php echo "https://" . $_SERVER['SERVER_NAME']."/seleniumMonitor"; ?></p>
				</li>
				<li>
					<span style="font-size: 75%;">
						<?php echo generateImage(
							$arrayOfImages["info"],
							array(
								"style"			=>	"margin-bottom: -4px;",
								"height"		=>	"20px",
								"srcModifier"	=>	"../"
							)
						); ?>
						<i>Please specify full url, blank if none</i></span>
				</li>
			</ul>
		</div>
	</form>
	<span id="moreAdvancedSpan">
		<div id="moreAdvanced" class="settingsHeader">
			Advanced
		</div>
		<div class="settingsDiv" >
			<ul class="settingsUl">
				<li>
					<a style="text-decoration: none;" href="../setup/step1.php" class="link">Re-do Setup</a>
					<span> | </span>
					<a onclick="revertPopup();" class="link">Revert Version</a>
					<span> | </span>
					<a onclick="resetUpdateNotification();" class="link">Reset Update Notification</a>
					<span> | </span>
					<a class="link" href="editFiles.php" >View Files</a>
				</li>
			</ul>
		</div>
	</span>
	<form id="expFeatures">
		<div class="settingsHeader">
		Experimental Features 
			<div class="settingsHeaderButtons">
				<a class="linkSmall" onclick="saveAndVerifyMain('expFeatures');" >Save Changes</a>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul class="settingsUl">
				<li>
					<span class="settingsBuffer"> New Log Formatting:</span>
					<div class="selectDiv">
						<select name="expFormatEnabled">
  							<option <?php if($expFormatEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($expFormatEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer"> Date Text Format:</span>
					<div class="selectDiv">
						<select name="dateTextFormat">
  							<option <?php if($dateTextFormat == 'default'){echo "selected";} ?> value="default">Default</option>
  							<option <?php if($dateTextFormat == 'hidden'){echo "selected";} ?> value="hidden">Hidden</option>
  							<option <?php if($dateTextFormat == 'hh:|mm:|ss'){echo "selected";} ?> value="hhmmss">hh:mm:ss</option>
  							<option <?php if($dateTextFormat == 'DD/|MM/|YYYY'){echo "selected";} ?> value="hhmmss">DD/MM/YYYY</option>
  							<option <?php if($dateTextFormat == 'MM/|DD/|YYYY'){echo "selected";} ?> value="hhmmss">MM/DD/YYYY</option>
  							<option <?php if($dateTextFormat == 'DD/|MM/'){echo "selected";} ?> value="hhmmss">DD/MM</option>
  							<option <?php if($dateTextFormat == 'DD/|MM/|YYYY |hh:|mm:|ss'){echo "selected";} ?> value="hhmmss">DD/MM/YYYY hh:mm:ss</option>
  							<option <?php if($dateTextFormat == 'YYYY/|MM/|DD |hh:|mm:|ss'){echo "selected";} ?> value="hhmmss">YYYY/MM/DD hh:mm:ss</option>
						</select>
					</div>
				</li>
			</ul>
		</div>
	</form>
	</div>
	<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post">
		<input type="hidden" style="width: 400px;"  name="newestVersion" value="<?php echo $configStatic['version'];?>" > 
	</form>
</body>
<script type="text/javascript">
	var htmlRestoreOptions = "<? echo generateRestoreList($configStatic); ?>";
</script>