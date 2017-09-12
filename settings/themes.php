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
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/themeFunctions.php');
require_once('../top/statusTest.php');
$withLogHog = $monitorStatus['withLogHog'];
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
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">

function goToUrl(url)
{
	window.location.href = url;
}

</script>
