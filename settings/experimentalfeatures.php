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
	<title>Settings | Main</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/expFeatures.js?v=<?php echo $cssVersion;?>"></script>
</head>
<body>
	<?php require_once('header.php');

if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(array_key_exists('enableSystemPrefShellOrPhp', $config))
{
	$enableSystemPrefShellOrPhp = $config['enableSystemPrefShellOrPhp'];
}
else
{
	$enableSystemPrefShellOrPhp = $defaultConfig['enableSystemPrefShellOrPhp'];
}
if(array_key_exists('popupSettingsArray', $config))
{
	$popupSettingsArray = $config['popupSettingsArray'];
}
else
{
	$popupSettingsArray = $defaultConfig['popupSettingsArray'];
}
?>
	
	

	<div id="main">
		<form id="expFeatures" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
		Experimental Features 
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsExpFeatures();" id="resetChangesExpFeaturesHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('expFeatures');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					System preference:
						<select name="enableSystemPrefShellOrPhp">
  						<option <?php if($enableSystemPrefShellOrPhp == 'true'){echo "selected";} ?> value="true">PHP</option>
  						<option <?php if($enableSystemPrefShellOrPhp == 'false'){echo "selected";} ?> value="false">shell_exec</option>
					</select>
				</li>
			</ul>
		</div>
		</form>
	</div>	
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script type="text/javascript">
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	function goToUrl(url)
	{
		var goToPage = !checkForChange();

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
		refreshSettingsExpFeatures();
		setInterval(poll, 100);
	});
</script>