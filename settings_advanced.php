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

if(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
} 
?>
<!doctype html>
<head>
	<title>Settings | Advanced</title>
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
		<a onclick="window.location.href = 'about.php'">About</a>
		<a onclick="window.location.href = 'update.php';"><?php  if($levelOfUpdate == 1){echo '<img src="../core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="../core/img/redWarning.png" height="10px">';} ?>Update</a>
		<a class="active">Advanced</a>
		<?php
		if($developmentTabEnabled == 'true'):?>
			<a onclick="window.location.href = 'devTools.php';"> Dev Tools </a>
		<?php endif; ?>
	</div>	
	<div id="main">
	<form id="devAdvanced" action="../core/php/settingsdevAdvancedSave.php" method="post">
		<div class="settingsHeader">
			Development  <button>Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					Enable Development Tools
						<select name="developmentTabEnabled">
  						<option <?php if($developmentTabEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($developmentTabEnabled == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
			</ul>
		</div>
	</form>
	</div>
</body>
<script src="../core/js/settings.js"></script>