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
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<div id="menu">
		<div onclick="window.location.href = '../index.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
		</div>
		<a class="active" >Main</a>
		<a onclick="window.location.href = 'about.php';">About</a>
		<a onclick="window.location.href = 'update.php';">Update</a>
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
		Main Settings
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				sliceSize:  <input type="text" name="sliceSize" value="<?php echo $config['sliceSize'];?>" >
			</li>
			<li>
				pollingRate: <input type="text" name="pollingRate" value="<?php echo $config['pollingRate'];?>" >
			</li>
			<li>
				pausePoll: 
					<select name="pausePoll">
  						<option <?php if($config['pausePoll'] == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($config['pausePoll'] == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				pauseOnNotFocus
				<select name="pauseOnNotFocus">
  						<option <?php if($config['pauseOnNotFocus'] == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($config['pauseOnNotFocus'] == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
		</ul>
		</div>
		<div class="settingsHeader">
			WatchList
		</div>
		<div class="settingsDiv" >	
		<ul id="settingsUl">
			<?php 
				$i = 0;
				foreach($config['watchList'] as $key => $item): $i++; ?>
			<li>
				File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: 
 				<input style='width: 500px;' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
 				<input type='text' name='watchListItem<?php echo $i; ?>' value='<?php echo $item; ?>'>
			</li>

		<?php endforeach; ?>
		<div id="newRowLocationForWatchList">
		</div>
		</ul>
		<ul id="settingsUl">
			<li>
				<button onclick="addRowFunction()">Add New File / Folder</button>
			</li>
		</ul>
		</div>
			
		
	</div>
	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript"> 
var countOfWatchList = <?php echo $i+1; ?>

function addRowFunction()
{
	if(countOfWatchList < 10)
	{
		document.getElementById('newRowLocationForWatchList').innerHTML += "<li>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' ></li>";
	}
	else
	{
		document.getElementById('newRowLocationForWatchList').innerHTML += "<li>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' ></li>";
	}
	
	countOfWatchList++;
}	
</script>