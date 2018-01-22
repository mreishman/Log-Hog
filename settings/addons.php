<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

//check if monitor is installed
$monitorInstalled = false;
$configStaticMonitor = null;

if(is_file("../monitor/index.php") === true)
{
	$monitorInstalled = true;
	$configStaticMain = $configStatic;
	require_once('../monitor/core/php/configStatic.php');
	$configStaticMonitor = $configStatic;
	$configStatic = $configStaticMain;
}

//check if search is installed
$searchInstalled = false;
$configStaticSearch = null;

if(is_file("../search/index.php") === true)
{
	$searchInstalled = true;
	$configStaticMain = $configStatic;
	require_once('../search/core/php/configStatic.php');
	$configStaticSearch = $configStatic;
	$configStatic = $configStaticMain;
}

//check if seleniumMonitor is installed
$seleniumMonitorInstalled = false;
$configStaticSeleniumMonitor = null;

if(is_file("../seleniumMonitor/index.php") === true)
{
	$seleniumMonitorInstalled = true;
	$configStaticMain = $configStatic;
	require_once('../seleniumMonitor/core/php/configStatic.php');
	$configStaticSeleniumMonitor = $configStatic;
	$configStatic = $configStaticMain;
}

$listOfAddons = array(
	"Monitor" => array(
		"Installed"		=> 	$monitorInstalled,
		"lowercase"		=>	"monitor",
		"uppercase"		=>	"Monitor",
		"Repo"			=>	"Monitor",
		"Description"	=> 	"A simple php server monitoring tool.",
		"ConfigStatic"	=>	$configStaticMonitor
	),
	"Search" => array(
		"Installed"		=> 	$searchInstalled,
		"lowercase"		=>	"search",
		"uppercase"		=>	"Search",
		"Repo"			=>	"Search",
		"Description"	=> 	"A simple visual grep tool that is intended for use on dev boxes.",
		"ConfigStatic"	=>	$configStaticSearch
	),
	"seleniumMonitor" => array(
		"Installed"		=> 	$seleniumMonitorInstalled,
		"lowercase"		=>	"seleniumMonitor",
		"uppercase"		=>	"SeleniumMonitor",
		"Repo"			=>	"SeleniumMonitor",
		"Description"	=> 	"A php based web monitor for selenium grids / an easy way to run tests",
		"ConfigStatic"	=>	$configStaticSeleniumMonitor
	)
);

?>
<!doctype html>
<head>
	<title>Settings | Addons</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/update.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			Addons
		</div>
		<div class="settingsDiv" >
			<table style="width: 100%;">
				<tr>
					<td>
					</td>
					<td width="25%">
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
					</td>
				</tr>
				<?php foreach ($listOfAddons as $key => $value):
				$lowercase = $value["lowercase"];
				$uppercase = $value["uppercase"];
				$repo = $value["Repo"];
				$installed = $value["Installed"];
				$description = $value["Description"];
				?> 
					<tr style="height: 10px;">
						<td colspan="6">
							<form id="<?php echo $lowercase; ?>UpdateForm" action="../<?php echo $lowercase; ?>/update/updater.php" method="post" ></form>
						</td>
					</tr>
					<tr>
						<th style="padding-left: 5px;">
							<?php echo $uppercase; ?>:
						</th>
						<td>
							<?php echo $description; ?>
						</td>
						<?php if($installed):?>
							<td>
								Version: <?php echo $value['ConfigStatic']['version'];?>
							</td>
							<?php if(strpos($URI, 'addons.php') !== false): ?>
								<td>
									<?php if ($value['ConfigStatic']['version'] !== $value['ConfigStatic']['newestVersion']): ?>
										Update Available - <?php echo $value['ConfigStatic']['newestVersion']; ?>
									<?php else: ?>
										No Update
									<?php endif; ?>
								</td>
								<td>
									<?php if ($value['ConfigStatic']['version'] !== $value['ConfigStatic']['newestVersion']): ?>
										<a class="link" onclick="installUpdates('../<?php echo $lowercase; ?>/','<?php echo $lowercase; ?>UpdateForm');">Install <?php echo $value['ConfigStatic']["newestVersion"];?> Update</a>
									<?php else: ?>
										<a onclick="checkForUpdates('../<?php echo $lowercase; ?>/','<?php echo $uppercase; ?>','<?php echo $value['ConfigStatic']['version'];?>','<?php echo $lowercase; ?>UpdateForm');" class="link">Check For Updates</a>
									<?php endif; ?>
								</td>
							<?php else: ?>
								<td colspan="2">
								</td>
							<?php endif; ?>
							<td>
								<script type="text/javascript">
								var <?php echo $key; ?> = "<?php echo $lowercase; ?>Remove"
								</script>
								<form id="<?php echo $lowercase; ?>Remove" action="addonAction.php" method="post">
									<input type="hidden" name="localFolderLocation" value="<?php echo $lowercase; ?>"> 
									<input type="hidden" name="repoName" value="<?php echo $repo; ?>">
									<input type="hidden" name="action" value="Removing">
								</form>
								<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Remove <?php echo $uppercase; ?></a>
							</td>
						<?php else: ?>
							<td colspan="3">
							</td>
							<td>
								<script type="text/javascript">
								var <?php echo $key; ?> = "<?php echo $lowercase; ?>Download"
								</script>
								<form id="<?php echo $lowercase; ?>Download" action="addonAction.php" method="post">
									<input type="hidden" name="localFolderLocation" value="<?php echo $lowercase; ?>"> 
									<input type="hidden" name="repoName" value="<?php echo $repo; ?>">
									<input type="hidden" name="action" value="Downloading">
								</form>
								<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Download <?php echo $uppercase; ?></a>
							</td>
						<?php endif; ?>
					</tr>
					<tr style="height: 10px;">
						<td colspan="6">
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="6">
						<?php echo generateImage(
							$arrayOfImages["info"],
							array(
								"style"			=>	"margin-bottom: -4px;",
								"height"		=>	"20px",
								"srcModifier"	=>	"../"
							)
						); ?>
			  			<i>Make sure you have run through setup before trying to update</i>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php require_once("../core/php/template/popup.php"); ?>	
</body>
<script type="text/javascript">
	function addonMonitorAction(idToSubmit)
	{
		document.getElementById(idToSubmit).submit();
	}

	currentVersion = "";
</script>