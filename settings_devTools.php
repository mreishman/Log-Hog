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
	<title>Settings | Dev Tools</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/devTools.js?v=<?php echo $cssVersion;?>"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<form id="devBranch" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Branch Settings  
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsDevBranch();" id="resetChangesDevBranchHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
					<a class="linkSmall" onclick="saveAndVerifyMain('devBranch');" >Save Changes</a>
				<?php else: ?>
					<button  onclick="displayLoadingPopup();">Save Changes</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Enable Development Branch: </span>
					<div class="selectDiv">
						<select name="enableDevBranchDownload">
  							<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
  							<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</div>
				</li>
				<li>
					<span class="settingsBuffer" >  Base URL:  </span> <input type="text" style="width: 400px;"  name="baseUrlUpdate" value="<?php echo $baseUrlUpdate;?>" > 
				</li>
				<li>
					<span class="settingsBuffer" > Config Version:  </span> <input type="text" style="width: 400px;"  name="configVersion" value="<?php echo $configVersion;?>" > 
				</li>
				<li>
					<span class="settingsBuffer" > Layout Version:  </span> <input type="text" style="width: 400px;"  name="layoutVersion" value="<?php echo $layoutVersion;?>" > 
				</li>
			</ul>
			

		</div>
	</form>
	<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post">
		<div class="settingsHeader">
			Static Config Settings  
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsDevAdvanced2();" id="resetChangesDevAdvanced2HeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<button onclick="displayLoadingPopup();" >Save Changes</button>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Version Number:  </span> <input type="text" style="width: 400px;"  name="version" value="<?php echo $configStatic['version'];?>" > 
				</li>
			</ul>
		</div>
	</form>
	<form id="devAdvanced3" action="../core/php/performSettingsInstallUpdateAction.php" method="post">
		<div class="settingsHeader">
			Update Progress File Settings
			<div class="settingsHeaderButtons">
				<a onclick="resetSettingsDevAdvanced3();" id="resetChangesDevAdvanced3HeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
				<button onclick="displayLoadingPopup();" >Save Changes</button>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
				(Default values below)
				</li>
				<li>
					<span class="settingsBuffer" >  Current Step:  </span> <input type="text" style="width: 400px;"  name="status" value="Finished Updating to " >
				</li>
				<li>
					<span class="settingsBuffer" >  Action:  </span> <input type="text" style="width: 400px;"  name="actionSave" value="finishedUpdate" >
				</li>
				<li>
					<span class="settingsBuffer" >  Percent:  </span> <input type="text" style="width: 400px;"  name="percent" value=0 >
				</li>
				<li style="display: none;">
					<input type="text" name="typeOfProgress" value="updateProgressFileNext.php" >
					<input type="text" name="pathToFile" value="">
					<input type="text" name="action" value="updateProgressFile">
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
	refreshSettingsDevBranch();
	refreshSettingsDevAdvanced2();
	refreshSettingsDevAdvanced3();
	setInterval(poll, 100);
});

</script>