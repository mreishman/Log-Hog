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
require_once('../core/php/commonFunctions.php');
require_once('../core/php/loadVars.php');

$localFolderLocation = "";
if(isset($_POST['localFolderLocation']))
{
	$localFolderLocation = $_POST['localFolderLocation'];
}

$repoName = "";
if(isset($_POST['repoName']))
{
	$repoName = $_POST['repoName'];
}

$action = "";
if(isset($_POST['action']))
{
	$action = $_POST['action'];
}

if($localFolderLocation === "" || $repoName === "")
{
	header("Location: "."advanced.php", true, 302); /* Redirect browser */
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $action;?> <?php echo $repoName;?></title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<script src="../core/js/jquery.js"></script>
	<?php readfile('../core/html/popup.html') ?>
	<script type="text/javascript">
		var localFolderLocation = "<?php echo $localFolderLocation;?>";
		var repoName = "<?php echo $repoName;?>";
	</script>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
		<h1><?php echo $action;?> <?php echo $repoName;?></h1>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
		<img src='../core/img/loading.gif' height='50' width='50'> 
	</div>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/settingsSave.php" method="post"></form>
<script type="text/javascript">

var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var urlForSendMain = "../core/php/performSettingsInstallUpdateAction.php?format=json";
var verifyFileTimer = null;
var dotsTimer = null;
var action = "<?php echo $action;?>";

$( document ).ready(function() 
{
	dotsTimer = setInterval(function() {document.getElementById('innerSettingsText').innerHTML = ' .'+document.getElementById('innerSettingsText').innerHTML;}, '120');
	document.getElementById('innerSettingsText').innerHTML = "";
	if(action === "Downloading")
	{
		checkIfTopDirIsEmpty();
	}
	else
	{
		removeFilesFromToppFolder(true);
	}
});

function finishedDownload()
	{
		clearInterval(dotsTimer);
		document.getElementById('innerSettingsText').innerHTML = "<br> <h1>Finished <?php echo $action;?> <?php echo $repoName;?><h1><br> <br> <a class='link' onclick='goBack();' >< Back to Settings</a>"
	}

	function goBack()
	{
		window.history.back();
	}
	
</script>
<script src="../core/js/settingsMain.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/loghogDownloadJS.js?v=<?php echo $cssVersion?>"></script>
</html>