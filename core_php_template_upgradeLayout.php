<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<link rel="icon" type="image/png" href="../../../core/img/favicon.png" />
	<script src="../../../core/js/jquery.js"></script>
</head>
<body>
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
require_once('../../../core/php/commonFunctions.php');
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

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Running Upgrade Scripts for Layout...</h1>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 350px; overflow: auto; max-height: 300px;">
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
			<p style="border-bottom: 1px solid white;"></p>
		</div>
	</div>
</div>
</body>

<script src="../../../core/js/settings.js?v=<?php echo $jsVersion?>"></script>
<script src="../../../core/js/upgradeMain.js?v=<?php echo $jsVersion?>"></script>
<script type="text/javascript">
	var urlForSendMain0 = '../../../core/php/checkVersionOfLayout.php?format=json';
	var urlForSendMain = '../../../core/php/upgradeScript/upgradeLayout-';
	var urlForSendMain2 = '.php?format=json';
	<?php
	echo "var startVersion = ".$layoutVersion.";";
	echo "var endVersion = ".$layoutVersionToUpgradeTo.";";
	echo "var upgradeConfigUrlToRedirectTo = \"getCookieRedirect();\"";
	?>
</script>
</html>