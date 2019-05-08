<!doctype html>
<?php
$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once("../../../core/php/class/core.php");
$core = new core();
require_once('../../../core/conf/config.php');
require_once('../../../core/php/configStatic.php');
require_once('../../../core/php/loadVars.php');

$layoutVersion = 0;
if(isset($config['layoutVersion']))
{
	$layoutVersion = $config['layoutVersion'];
}
$layoutVersionToUpgradeTo = $defaultConfig['layoutVersion'];
$totalUpgradeScripts = floatval($layoutVersionToUpgradeTo) - floatval($layoutVersion) ;
?>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/base.css">
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<?php require_once("../../../core/php/customCSS.php"); ?>
	<link rel="icon" type="image/png" href="../../../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../../../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
<div id="main" style=" position: relative;">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Running Upgrade Scripts for Layout...</h1>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<p class="addBorderBottom"></p>
			<div id="innerDisplayUpdate">
			<table style="padding: 10px;">
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
			<p class="addBorderBottom"></p>
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
	var urlForSendMain0 = '../../../core/php/checkVersionOfLayout.php?format=json';
	var urlForSendMain = '../../../core/php/upgradeScript/upgradeLayout-';
	var urlForSendMain2 = '.php?format=json';
	<?php
	echo "var startVersion = ".$layoutVersion.";";
	echo "var endVersion = ".$layoutVersionToUpgradeTo.";";
	echo "var upgradeConfigUrlToRedirectTo = \"".$core->getCookieRedirect()."\"";
	?>
</script>
</html>