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
$seperateFromLogHog = true;
if(file_exists('../top/statusTest.php'))
{
	$seperateFromLogHog = false;
}
if(file_exists($baseUrl.'conf/topConfig.php'))
{
	require_once($baseUrl.'conf/topConfig.php'); 
} 
require_once('../core/conf/configTop.php');
require_once('../core/php/loadVarsTop.php');
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
	<?php if($seperateFromLogHog): ?>
	<div id="main">	
	<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Main Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
			
				<li>
					<span class="settingsBuffer" > Auto Check Update: </span> 
						<select id="settingsSelect" name="autoCheckUpdate">
								<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
								<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
						</select>

					<div id="settingsAutoCheckVars" <?php if($autoCheckUpdate == 'false'){echo "style='display: none;'";}?> >

					<div class="settingsHeader">
						Auto Check Update Settings
						</div>
						<div class="settingsDiv" >
						<ul id="settingsUl">
						
							<li>
							<span class="settingsBuffer" > Check for update every: </span> 
								<input type="text" name="autoCheckDaysUpdate" value="<?php echo $autoCheckDaysUpdate;?>" >  Day(s)
							</li>
							<li>
							<span class="settingsBuffer" > Notify Updates on: </span> 
								<select id="updateNoticeMeter" name="updateNoticeMeter">
			  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
			  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
								</select>
							</li>

						</ul>
						</div>
					</div>

				</li>
				<li>
					<span class="settingsBuffer" > Popup Warnings: </span> 
						<select id="popupSelect"  name="popupWarnings">
								<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
								<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
								<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
						</select>
					<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

					<div class="settingsHeader">
						Popup Settings
						</div>
						<div class="settingsDiv" >
						<ul id="settingsUl">
						<?php foreach ($popupSettingsArray as $key => $value):?>
							<li>
							<span class="settingsBuffer" > <?php echo $key;?>: </span> 
								<select name="<?php echo $key;?>">
			  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
			  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
								</select>
							</li>
						<?php endforeach;?>
						</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</form>
	</div>
	<?php endif;?>
	<div id="main">	
	<form id="settingsMainVars" action="../core/php/settingsSaveTop.php" method="post">
		<div class="settingsHeader">
			Top Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
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

document.getElementById("popupSelect").addEventListener("change", showOrHidePopupSubWindow, false);
document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);

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

function showOrHidePopupSubWindow()
{
	var valueForPopup = document.getElementById('popupSelect').value;
	if(valueForPopup == 'custom')
	{
		document.getElementById('settingsPopupVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsPopupVars').style.display = 'none';
	}
}
function showOrHideUpdateSubWindow()
{
	var valueForPopup = document.getElementById('settingsSelect').value;
	if(valueForPopup == 'true')
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'none';
	}
}
</script>