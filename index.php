<?php
require_once("core/php/class/core.php");
$core = new core();
require_once("core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("", "", 14);
}
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
if($currentSelectedTheme !== false) {
	$core->goToUrl("index.php","main.php");
}
$core->setCookieRedirect();
$varTemplateSrcModifier = "";
$config = array();
require_once('core/conf/config.php');
require_once('core/conf/globalConfig.php');
if(is_file('local/conf/globalConfig.php'))
{
	require_once('local/conf/globalConfig.php');
}
else
{
	$globalConfig = array();
}
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$defaultSettingsDir = 'core/Themes/'.$currentTheme."/defaultSetting.php";
require_once($defaultSettingsDir);
require_once('core/php/configStatic.php');
require_once('core/php/loadVars.php');
require_once('core/php/loadVarsToJs.php');
$scanned_directory = array_diff(scandir("local/profiles/"), array('..', '.'));
?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<?php $core->getScripts(
		array(
			array(
				"filePath"		=> "core/js/jquery.js",
				"baseFilePath"	=> "core/js/jquery.js",
				"default"		=> $configStatic["version"]
			)
		)
	); ?>
	<?php
		echo $core->loadSentryData($sendCrashInfoJS, $branchSelected, $configStatic);
		require_once("core/php/indexJsObjectCreator.php");
	?>
	<style type="text/css">
		body{
			color: black;
			background-color: #191919;
			background-image:url("core/img/background.jpg");
			font-family: monospace;
			padding: 0;
			margin: 0;
		  	height: 100%;
		}
		.button {
			font-size: 16px;
			border: 2px solid black;
			color: black;
			cursor: pointer;
			height: 40px;
		}
		.button img{
			vertical-align:middle;
		}
		.button:hover{
			color: white;
			border: 2px solid white;
			background-color: black;
		}
		.button:hover img{
			filter: invert(0) !important;
		}
	</style>
</head>
<body>
	<div style="position: absolute; left: 0; top: 0; bottom: 0; padding: 2% 2% 2% 1%; background: rgba(255,255,255,.7); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border-right: 1px solid black;box-shadow: 5px 5px 5px rgba(0,0,0,.5);">
		<div style="height: 80%;">
			<h1>Log-Hog <?php echo $configStatic["version"]; ?></h1>
			<h2>Pick a profile:</h2>
			<div style="max-height: 50%; overflow-y: auto;">
				<?php
				foreach ($scanned_directory as $profile): ?>
					<div class="button">
						<img src="core/img/favicon.png" height="40px">
						<?php echo $profile; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<h2>Create a profile:</h2>
			<div class="button">
				<img src="core/img/favicon.png" height="40px">
				+ New Profile
			</div>
		</div>
		<div class="button">
			<img style="filter: invert(1);" src="core/img/Gear.png" height="40px">
			Settings
		</div>
	</div>
</body>