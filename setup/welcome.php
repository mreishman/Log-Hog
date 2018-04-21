<?php
require_once('../core/php/errorCheckFunctions.php');
$currentPage = "welcome.php";
checkIfFilesExist(
	array("local/layout.php","setup/setupProcessFile.php","error.php","setup/step1.php","core/template/theme.css","core/js/jquery.js","core/php/template/popup.php","core/php/settingsSaveAjax.php","core/conf/config.php","setup/stepsJavascript.js"),
	 "../",
	 $currentPage);
checkIfFilesAreReadable(
	array("local/layout.php","setup/setupProcessFile.php","error.php","setup/step1.php","core/template/theme.css","core/js/jquery.js","core/php/template/popup.php","core/php/settingsSaveAjax.php","core/conf/config.php","setup/stepsJavascript.js"),
	 "../",
	 $currentPage);



function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}


$baseUrl = "../local/";
//there is custom information, use this
require_once('../local/layout.php');
$baseUrl .= $currentSelectedTheme."/";


checkIfFilesAreWritable(
	array("core/php/settingsSaveAjax.php","local/".$currentSelectedTheme, "setup/setupProcessFile.php"),
	 "../",
	 $currentPage);

require_once('setupProcessFile.php');
if(file_exists($baseUrl.'conf/config.php'))
{
	if($setupProcess != "preStart")
	{
		$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
		$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
		$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
		header('Location: ' . $url, true, 302);
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../core/template/base.css">
	<script src="../core/js/jquery.js"></script>
	<?php require_once("../core/php/template/popup.php"); ?>	
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Thank you for downloading Log-Hog.</h1>
	</div>
	<div class="settingsDiv" >
	<p style="min-height: 200px; padding: 10px;">Please follow these steps to complete the setup process or click default to accept default setting</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" >
		<tr>
			<th style="text-align: left;">
				<a onclick="updateStatus('finished');" class="link">Accept Default Settings</a>
			</th>
			<th style="text-align: right;" >
				<a onclick="updateStatus('step1');" class="link">Customize Settings (advised)</a>
			</th>
		</tr>
	</table>
	<br>
	<br>
	</div>
</div>
</body>
<form id="welcomeForm"></form>
<script type="text/javascript">
	function defaultSettings()
	{
		//change setupProcess to finished
		saveAndVerifyMain("welcomeForm");
	}

	function customSettings()
	{
		//change setupProcess to page1
		saveAndVerifyMain("welcomeForm");
	}

	var saveVerifyImage = "../core/img/greenCheck.png";
</script>
<script src="../core/js/settings.js?v=<?php echo rand(0,2000); ?>"></script>
<script src="stepsJavascript.js?v=1"></script> <!-- Try to remember to manually increment this one? -->
</html>