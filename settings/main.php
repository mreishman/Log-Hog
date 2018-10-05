<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/configStatic.php');
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<?php echo loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header.php');?>

	<div id="main">
		<?php
		$currentSection = "logVars";
		include('../core/php/template/varTemplate.php');
		if($expFormatEnabled === "true")
		{
			$currentSection = "logFormatVars";
			include('../core/php/template/varTemplate.php');
		}
		$currentSection = "pollVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "filterVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "archive";
		include('../core/php/template/varTemplate.php');
		$currentSection = "updateVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "menuVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "watchlistVars";
		include('../core/php/template/varTemplate.php');
		if($enableMultiLog === "true")
		{
			$currentSection = "multiLogVars";
			include('../core/php/template/varTemplate.php');
			require_once('../core/php/template/logLayout.php');
		}
		$currentSection = "otherVars";
		include('../core/php/template/varTemplate.php');
		?>
	</div>
</body>
<script type="text/javascript">
var logTrimType = "<?php echo $logTrimType; ?>";
</script>
<script src="../core/js/settingsMain.js?v=<?php echo $cssVersion?>"></script>