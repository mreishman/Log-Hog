<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); ?>
<!doctype html>
<head>
	<title>Log Hog | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<div id="menu">
		<div onclick="window.location.href = '../index.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
		</div>
		<a onclick="window.location.href = 'main.php';" >Main</a>
		<a class="active">About</a>
		<a onclick="window.location.href = 'update.php';">Update</a>
	</div>	
	<div id="main">
		<div class="settingsHeader">
		About
		</div>
		<div class="settingsDiv" >
		<h2>Log-Hog</h2>
		<p>A simple log monitoring tool that is intended for use on dev boxes.</p>

		<p>If you need Log Hog to watch Apache's logs, see this: <a href="https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions">https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions</a></p>


		<p>Includes files from the following project: </p>

		<p> <a href="https://github.com/ai/visibilityjs">https://github.com/ai/visibilityjs </a> </p> 
		</div>
		<div class="settingsHeader">
		GitHub
		</div>
		<div class="settingsDiv" >
		<h2>Github</h2>
		<p>View the project on github: <a href="https://github.com/mreishman/Log-Hog">https://github.com/mreishman/Log-Hog</a> </p>

		<p>Add an issue: <a href="https://github.com/mreishman/Log-Hog/issues">https://github.com/mreishman/Log-Hog/issues</a></p>

		</div>
	</div>
</body>