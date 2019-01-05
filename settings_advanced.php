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
	<script src="../core/js/advanced.js?v=<?php echo $jsVersion;?>"></script>
	<script src="../core/js/resetSettingsJs.js?v=<?php echo $jsVersion;?>"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<?php
	$currentSection = "config";
	include('../core/php/template/varTemplate.php');
	$currentSection = "modules";
	include('../core/php/template/varTemplate.php');
	$currentSection = "loggingVars";
	include('../core/php/template/varTemplate.php');
	$currentSection = "fileLocations";
	include('../core/php/template/varTemplate.php');
	?>
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
					<span> | </span>
					<?php if($backupNumConfigEnabled == 'true'): ?>
						<a onclick="showConfigPopup();" class="link">View restore options for config</a>
						<span> | </span>
						<?php if($showConfigBackupClear): ?>
							<span id="showConfigClearButton">
								<a onclick="clearBackupFiles();" class="link">Clear (<?php echo $countConfig;?>) Backup Config Files</a>
								<span> | </span>
							</span>
						<?php endif; ?>
					<?php endif; ?>
					<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
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
			</ul>
		</div>
	</form>
	</div>
	<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post"> <!-- Reset update notification form -->
		<input type="hidden" style="width: 400px;"  name="newestVersion" value="<?php echo $configStatic['version'];?>" > 
	</form>
</body>
<script type="text/javascript">
	var htmlRestoreOptions = "<?php echo generateRestoreList($configStatic); ?>";
	var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
</script>