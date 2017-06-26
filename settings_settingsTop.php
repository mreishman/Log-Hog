
<meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
<meta http-equiv="expires" content="Sat, 31 Oct 2014 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

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
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
?>
<!doctype html>
<head>
	<title>Settings | Top</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main">	
	<form id="topMain" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Top Settings Main <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" > Poll Rate Main: </span>  <input type="text" name="pollingRateOverviewMain" value="<?php echo $pollingRateOverviewMain;?>" >
					<select name="pollingRateOverviewMainType">
							<option <?php if($pollingRateOverviewMainType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
							<option <?php if($pollingRateOverviewMainType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
					</select>
				</li>
				<li>
					<span class="settingsBuffer" > Poll Rate Slow: </span>  <input type="text" name="pollingRateOverviewSlow" value="<?php echo $pollingRateOverviewSlow;?>" >
					<select name="pollingRateOverviewSlowType">
							<option <?php if($pollingRateOverviewSlowType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
							<option <?php if($pollingRateOverviewSlowType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
					</select>
				</li>
			</ul>
		</div>
	</form>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
function goToUrl(url)
	{
		if(true)
		{
			window.location.href = url;
		}
		else
		{
			displaySavePromptPopup(url);
		}
	}
</script>