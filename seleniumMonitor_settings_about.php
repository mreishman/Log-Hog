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
	<title>Settings | About</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			About
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Version - <?php echo $configStatic['version'];?></h2>
				</li>
			</ul>
		</div>
		<div class="settingsHeader">
			Info
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Selenium Monitor</h2>
				</li>
				<li>
					<p>A visual monitor for selenium grids. Also adds the ability to run php tests from a web interface</p>
				</li>
				<li>
					<h2>Github</h2>
				</li>
				<li>
					<p>View the project on github: <a href="https://github.com/mreishman/SeleniumMonitor">https://github.com/mreishman/SeleniumMonitor</a> </p>

					<p>Add an issue: <a href="https://github.com/mreishman/SeleniumMonitor/issues">https://github.com/mreishman/SeleniumMonitor/issues</a></p>
				</li>
			</ul>
		</div>
	</div>
</body>