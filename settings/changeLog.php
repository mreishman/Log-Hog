<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/conf/globalConfig.php');
require_once('../local/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/Themes/'.$currentTheme))
{
	require_once('../local/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

?>
<!doctype html>
<head>
	<title>Settings | Update</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
	<?php require_once('header2.php'); ?>
	<div id="main">
		<?php
			require_once("../core/php/template/changelog.php");
		?>
	</div>
</body>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}

</script>