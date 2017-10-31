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
	<title>Settings | Dev</title>
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
				<?php echo addResetButton("devBranch");
				if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
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
	<form id="devAdvanced2">
		<div class="settingsHeader">
			Static Config Settings  
			<div class="settingsHeaderButtons">
				<?php echo addResetButton("devAdvanced2");?>
				<a class="linkSmall" onclick="saveConfigStatic();" >Save Changes</a>
			</div>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" >  Version Number:  </span> <input id="versionNumberConfigStaticInput" type="text" style="width: 400px;"  name="version" value="<?php echo $configStatic['version'];?>" > 
				</li>
			</ul>
		</div>
	</form>
	<form id="devAdvanced3" action="../core/php/performSettingsInstallUpdateAction.php" method="post">
		<div class="settingsHeader">
			Update Progress File Settings
			<div class="settingsHeaderButtons">
				<?php echo addResetButton("devAdvanced3");?>
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

	<div class="settingsHeader">
			Edit Files
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
				Insert Links Here
				</li>
			</ul>
		</div>


	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>