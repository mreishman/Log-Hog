<!doctype html>
<?php
require_once("../../../core/php/class/core.php");
$core = new core();
require_once("../../../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("", "", 14);
}
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../../core/conf/config.php');
require_once('../../../core/conf/globalConfig.php');
require_once('../../../local/conf/globalConfig.php');
require_once('../../../core/php/configStatic.php');
require_once('../../../core/php/loadVars.php');
$globalConfigVersion = 0;
if(isset($globalConfig['globalConfigVersion']))
{
	$globalConfigVersion = $globalConfig['globalConfigVersion'];
}
$globalConfigVersionToUpgradeTo = $defaultGlobalConfig['globalConfigVersion'];
$totalUpgradeScripts = floatval($globalConfigVersionToUpgradeTo) - floatval($globalConfigVersion);
?>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/base.css">
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../../../core/template/upgrade.css">
	<?php require_once("../../../core/php/customCSS.php"); ?>
	<link rel="icon" type="image/png" href="../../../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../../../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
<div id="upgradeStatusPopup">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Running Upgrade Scripts for Config...</h1>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<div id="innerDisplayUpdate">
			<table style="padding: 10px; height: 100%;">
				<tr>
					<td style="height: 50px;">
						<img id="runLoad" src="../../../core/img/loading.gif" height="30px;">
						<img id="runCheck" style="display: none;" src="../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Running upgrade script <span id="runCount">1</span> of <?php echo $totalUpgradeScripts;?>
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="verifyLoad" style="display: none;" src="../../../core/img/loading.gif" height="30px;">
						<img id="verifyCheck" style="display: none;" src="../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verifying upgrade script <span id="verifyCount">1</span> of <?php echo $totalUpgradeScripts;?>
					</td>
				</tr>
			</table>
			</div>
		</div>
	</div>
</div>
</body>
<?php $core->getScripts(array(
		array(
			"filePath"		=> "../../../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../../../core/js/upgradeMain.js",
			"baseFilePath"	=> "core/js/upgradeMain.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
	$( document ).ready(function()
	{
		$("body").height(""+window.innerHeight+"px");
	});
	$( window ).resize(function() {
		$("body").height(""+window.innerHeight+"px");
	});
	var urlForSendMain0 = '../../../core/php/checkVersionOfGlobalConfig.php?format=json';
	var urlForSendMain = '../../../core/php/upgradeScript/upgradeGlobalConfig-';
	var urlForSendMain2 = '.php?format=json';
	<?php
	echo "var startVersion = ".$globalConfigVersion.";";
	echo "var endVersion = ".$globalConfigVersionToUpgradeTo.";";
	echo "var upgradeConfigUrlToRedirectTo = \"".$core->getCookieRedirect()."\"";
	?>
</script>
</html>