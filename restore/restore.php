<?php
$baseUrl = "../core/";
$cssVersion = rand(0 , 9000000);
$versionToRestoreTo = 0;
if(isset($_POST['versionRevertTo']))
{
	$versionToRestoreTo = $_POST['versionRevertTo'];
}
require_once('../core/php/loadVars.php');
require_once('../core/php/commonFunctions.php');
require_once('../core/php/configStatic.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css?v=<?php echo $cssVersion;?>">
	<link rel="stylesheet" type="text/css" href="../core/template/base.css?v=<?php echo $cssVersion;?>">
	<script src="../core/js/jquery.js"></script>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
	<?php if($versionToRestoreTo != 0): ?>
		<h1>Restoring to version <?php echo $versionToRestoreTo; ?></h1>
	<?php else: ?>
		<h1>Select a version to restore to: <?php echo generateRestoreList($configStatic);?> <button class="link" onclick="document.getElementById('revertForm').submit();"  >Restore</button></h1>
	<?php endif;?>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
	<?php if($versionToRestoreTo != 0): ?>
		<img src='../core/img/loading.gif' height='50' width='50'> 
	<?php endif; ?>
	</div>
	<br>
	<br>
</div>
</body>
<script src="restore.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">

var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var urlForSendMain = './php/performSettingsInstallUpdateAction.php?format=json';
var verifyFileTimer = null;
var dotsTimer = null;
var fileVersionDownload = null;
<?php if($versionToRestoreTo != 0): ?>
fileVersionDownload = '<?php echo $versionToRestoreTo; ?>';
<?php endif ;?>
var verifyCountSuccess = 0;

$( document ).ready(function() 
{
	if(fileVersionDownload)
	{
		startLogic();
	}
});
</script>
</html>