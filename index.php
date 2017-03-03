<?php require_once('config/config.php'); ?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<link rel="stylesheet" type="text/css" href="static/theme.css">
	<link rel="icon" type="image/png" href="static/images/favicon.png" />
	<script src="static/jquery.js"></script>
	<script src="static/visibility.core.js"></script>
	<script src="static/visibility.fallback.js"></script>
	<script src="static/visibility.js"></script>
	<script src="static/visibility.timers.js"></script>
</head>
<body>
	<div id="menu">
		<div onclick="pausePollAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="static/images/Pause.png" height="30px">
		</div>
		<div onclick="refreshAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="refreshImage" class="menuImage" src="static/images/Refresh.png" height="30px">
		</div>
	</div>
	
	<div id="main">
		<div id="log"></div>
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a class="{{id}}Button" onclick="show(this, '{{id}}')">{{title}}</a>
		</div>
	</div>
	
	<div id="title">&nbsp;</div>
	
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
	
	<script src="static/main.js"></script>
</body>