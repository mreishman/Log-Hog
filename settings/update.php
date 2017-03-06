<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); ?>
<!doctype html>
<head>
	<title>Log Hog | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<div id="menu">
		<div onclick="window.location.href = '../index.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
		</div>
		<a onclick="window.location.href = 'main.php';" >Main</a>
		<a onclick="window.location.href = 'about.php';">About</a>
		<a class="active">Update</a>
	</div>
	
	
	<script>
		var pollingRate = <?php echo $config['pollingRate'] ?>;
		var pausePoll = false;
		var pausePollFromFile = <?php echo $config['pausePoll'] ?>;
		var pausePollOnNotFocus = <?php echo $config['pauseOnNotFocus'] ?>;
		var refreshActionVar;
		var refreshPauseActionVar;
		var userPaused = false;
		var refreshing = false;
	</script>
	
	<div id="main">
		<div class="settingsHeader">
		Update
		</div>
		<div class="settingsDiv" >
		</div>
	</div>

</body>