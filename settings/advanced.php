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
				<button onclick="displayLoadingPopup();" >Save Changes</button>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
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
	<form id="loggingDisplay" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Logging Information 
			<div class="settingsHeaderButtons">
				<button onclick="displayLoadingPopup();" >Save Changes</button>
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
		<div class="settingsHeader">
			Reset Config Values back to default
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<form id="resetSettings" action="../core/php/settingsSave.php" method="post">
					<li>
						<a onclick="document.getElementById('resetSettings').submit()" class="link">Reset Settings</a>
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
			goToPage = false;
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
</script>