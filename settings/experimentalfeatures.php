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

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}

require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php');

if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(array_key_exists('enableSystemPrefShellOrPhp', $config))
{
	$enableSystemPrefShellOrPhp = $config['enableSystemPrefShellOrPhp'];
}
else
{
	$enableSystemPrefShellOrPhp = $defaultConfig['enableSystemPrefShellOrPhp'];
}
if(array_key_exists('popupSettingsCustom', $config))
{
	$popupSettingsArray = $config['popupSettingsCustom'];
}
else
{
	$popupSettingsArray = $defaultConfig['popupSettingsCustom'];
}
if(array_key_exists('enableHtopLink', $config))
{
	$enableHtopLink = $config['enableHtopLink'];
}
else
{
	$enableHtopLink = $defaultConfig['enableHtopLink'];
}
?>
	
	

	<div id="main">
		<form id="devAdvanced" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
		Experimental Features <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					System preference:
						<select name="enableSystemPrefShellOrPhp">
  						<option <?php if($enableSystemPrefShellOrPhp == 'true'){echo "selected";} ?> value="true">PHP</option>
  						<option <?php if($enableSystemPrefShellOrPhp == 'false'){echo "selected";} ?> value="false">shell_exec</option>
					</select>
				</li>
				<li>
					Htop link:
						<select name="enableHtopLink">
  						<option <?php if($enableHtopLink == 'true'){echo "selected";} ?> value="true">Enabled</option>
  						<option <?php if($enableHtopLink == 'false'){echo "selected";} ?> value="false">Disabled</option>
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
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	function goToUrl(url)
	{
		var goToPage = true
		if(document.getElementsByName("enableSystemPrefShellOrPhp")[0].value != "<?php echo $enableSystemPrefShellOrPhp;?>")
		{
			goToPage = false;
		}

		if(goToPage || popupSettingsArray.saveSettings == "false")
		{
			window.location.href = url;
		}
		else
		{
			showPopup();
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Changes not Saved!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to leave the page without saving changes?</div><div class='link' onclick='window.location.href = "+'"'+url+'"'+";' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
	}
</script>