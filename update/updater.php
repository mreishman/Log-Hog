<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
?>

<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
</body>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<h1>Updating to version <?php echo $configStatic['newestVersion'] ; ?></h1>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
		<p id="headerForUpdate">Downloading files for _____ update. </p>
		<p style="border-bottom: 1px solid white;"></p>
		<p> Other stuff here </p>
		</div>
	</div>
</div>
<script src="../core/js/settings.js"></script>
<script type="text/javascript"> 
var headerForUpdate = document.getElementById('headerForUpdate');
setInterval(function() {headerForUpdate.innerHTML = headerForUpdate.innerHTML + '.';}, '100');
</script>  