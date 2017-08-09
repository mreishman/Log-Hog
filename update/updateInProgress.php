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
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php'); 
require_once('../top/statusTest.php');
?>
<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>


<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<h1>An Update is in progress</h1>
		<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
			<a onclick="window.location.href = '../settings/update.php'">Back to Log-Hog</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress id="progressBar" value="0" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px;">

			</div>
			<p style="border-bottom: 1px solid white;"></p>
			<div class="settingsHeader">
			Log Info
			</div>
			<div id="innerSettingsText" class="settingsDiv" style="height: 75px; overflow-y: scroll;" >
				
			</div>
		</div>
	</div>
</div>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
	

	
</script>
</body>
</html>