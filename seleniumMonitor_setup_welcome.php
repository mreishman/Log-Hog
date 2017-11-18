<?php

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}



$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

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
	<script src="../core/js/jquery.js"></script>
	<?php readfile('../core/html/popup.html') ?>	
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Thank you for downloading Selenium Monitor.</h1>
	</div>
	<div class="settingsDiv" >
	<p style="min-height: 200px; padding: 10px;">Please follow these steps to complete the setup process or click default to accept default setting</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" >
		<tr>
			<th style="text-align: left;">
				<?php if(file_exists($baseUrl.'conf/config.php')):?>
					<a onclick="updateStatus('finished');" class="link">Accept Current Settings</a>
				<?php else: ?>
					<a onclick="updateStatus('finished');" class="link">Accept Default Settings</a>
				<?php endif;?>
			</th>
			<!-- 
			<th style="text-align: right;" >
				<a onclick="updateStatus('step1');" class="link">Customize Settings (advised)</a>
			</th>
			-->
		</tr>
	</table>
	<br>
	<br>
	</div>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/settingsSave.php" method="post"></form>
<script type="text/javascript">
	function defaultSettings()
	{
		//change setupProcess to finished
		document.getElementById('defaultVarsForm').submit();
	}

	function customSettings()
	{
		//change setupProcess to page1
		document.getElementById('defaultVarsForm').submit();
	}
</script>
<script src="stepsJavascript.js?v=1"></script> <!-- Try to remember to manually increment this one? -->
</html>