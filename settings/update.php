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
//$timestamp = date('m-d-Y');
 ?>
<!doctype html>
<head>
	<title>Log Hog | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
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
			<ul id="settingsUl">
				<li>
					<h2>Current Version - <?php echo $configStatic['version'];?></h2>
				</li>	
				<li>
					<h2>Last Check for updates -  <?php echo $configStatic['lastCheck'];?></h2>
				</li>
				<li>
					<button onclick="checkForUpdates();">Check for updates</button>
				</li>
				<li id="noUpdate" style="display: none;">
					<h2><img id="statusImage1" src="../core/img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
				</li>
				<li id="minorUpdate" style="display: none;">
					<h2><img id="statusImage2" src="../core/img/yellowWarning.png" height="15px"> &nbsp; Minor Updates - bug fixes </h2>
				</li>
				<li id="majorUpdate" style="display: none;">
					<h2><img id="statusImage3" src="../core/img/redWarning.png" height="15px"> &nbsp; Major Updates - new features!</h2>
				</li>
			</ul>
		</div>
		<div class="settingsHeader">
			Changelog
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Changelog</h2>
				</li>
				<li>
					1.3
					<ul>
						<li>
							Added Un-pause on focus
						</li>
						<li>
							Dynamic title of page (reflects status of paused and refreshing)
						</li>
					</ul>
				</li>
				<li>
					1.2
					<ul>
						<li>
							Added Refresh button
						</li>
					</ul>
				</li>
				<li>
					1.1
					<ul>
						<li>
							Added Pause / Play button
						</li>
					</ul>
				</li>
				<li>
					1.0
					<ul>
						<li>
							Initial Forked version from craig-russell
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
function checkForUpdates()
{
	
}
</script>