
<meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
<meta http-equiv="expires" content="Sat, 31 Oct 2014 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

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
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/commonFunctions.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main">
		<?php require_once('../core/php/template/mainVars.php'); ?>
		<?php require_once('../core/php/template/settingsMainWatch.php'); ?>
		<?php require_once('../core/php/template/generalThemeOptions.php'); ?>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>

<script src="../core/js/settingsMain.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">
document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);
var mainData;
var watchlistData;
var menuData;


var countOfWatchList = 0;
var countOfAddedFiles = 0;
var countOfClicks = 0;
var locationInsert = "newRowLocationForWatchList";
	var savedInnerHtmlWatchList;
	var savedInnerHtmlMainVars;
	var savedInnerHtmlMenu;
var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var countOfWatchListStatic = countOfWatchList;
var countOfAddedFilesStatic = countOfAddedFiles;
var countOfClicksStatic = countOfClicks;
var locationInsertStatic = locationInsert;

function goToUrl(url)
{
	var goToPage = true
	if(popupSettingsArray.saveSettings != "false")
	{
		goToPage = !checkForChangesMainSettings();
	}
	if(goToPage)
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
	refreshSettingsMainVar();
	setInterval(poll, 100);
});

</script>