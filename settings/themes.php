<?php
require_once('../core/php/commonFunctions.php');
$baseUrl = "../local/";
//there is custom information, use this
require_once('../local/layout.php');
$baseUrl .= $currentSelectedTheme."/";
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
	<title>Settings | Themes</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
<?php require_once('header.php');?>	
	<div id="main">
		<?php require_once('../core/php/template/themeMain.php'); ?>
		<?php require_once('../core/php/template/generalThemeOptions.php'); ?>
		<?php require_once('../core/php/template/folderGroupColor.php'); ?>
	</div>
</body>
<script src="../core/js/themes.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">
	var currentTheme = "<?php echo $currentSelectedTheme; ?>";
</script>