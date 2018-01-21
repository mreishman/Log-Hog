<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

?>
<!doctype html>
<head>
	<title>Settings | Update</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header2.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			Changelog
		</div>
		<?php readfile('changelog.html') ?>
	</div>
</body>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}

</script>