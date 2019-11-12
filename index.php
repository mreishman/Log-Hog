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
</head>
<body>
	<h1>Log-Hog <?php echo $configStatic["version"]; ?></h1>
	<h2>Pick a profile:</h2>
	<?php
	foreach ($scanned_directory as $profile): ?>
		<div>
			<?php echo $profile; ?>
		</div>
	<?php endforeach; ?>
	<h2>Or create a new profile:</h2>
</body>