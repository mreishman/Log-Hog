<?php
require_once('../core/php/commonFunctions.php');

$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

//check if monitor is installed
$monitorInstalled = false;
$configStaticMonitor;

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
$configStaticSearch;

if(is_file("../search/index.php") === true)
{
	$searchInstalled = true;
	$configStaticMain = $configStatic;
	require_once('../search/core/php/configStatic.php');
	$configStaticSearch = $configStatic;
	$configStatic = $configStaticMain;
}

$listOfAddons = array(
	"Monitor" => array(
		"Installed"		=> 	$monitorInstalled,
		"lowercase"		=>	"monitor",
		"uppercase"		=>	"Monitor",
		"Repo"			=>	"Monitor",
		"ConfigStatic"	=>	$configStaticMonitor
	),
	"Search" => array(
		"Installed"		=> 	$searchInstalled,
		"lowercase"		=>	"search",
		"uppercase"		=>	"Search",
		"Repo"			=>	"Search",
		"ConfigStatic"	=>	$configStaticSearch
	)
);

?>
<!doctype html>
<head>
	<title>Settings | Addons</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			Addons
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<?php foreach ($listOfAddons as $key => $value):
				$lowercase = $value["lowercase"];
				$uppercase = $value["uppercase"];
				$repo = $value["Repo"];
				$installed = $value["Installed"];
				?> 
					<li>
						<?php if($installed):?>
							Version: <?php echo $value['ConfigStatic']['version'];?>
							|
							<?php if $value['ConfigStatic']['version'] !== $value['ConfigStatic']['newestVersion']: ?>
								Update Available
							<?php else: ?>
								No Update
							<?php endif; ?>
							|
							Check For Updates
							|
							<script type="text/javascript">
							var <?php echo $key; ?> = "<?php echo $lowercase; ?>Download"
							</script>
							<form id="<?php echo $lowercase; ?>Download" action="addonAction.php" method="post">
								<input type="hidden" name="localFolderLocation" value="<?php echo $lowercase; ?>"> 
								<input type="hidden" name="repoName" value="<?php echo $repo; ?>">
								<input type="hidden" name="action" value="Downloading">
							</form>
							<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Download <?php echo $uppercase; ?></a>
						<?php else: ?>
							<script type="text/javascript">
							var <?php echo $key; ?> = "<?php echo $lowercase; ?>Remove"
							</script>
							<form id="<?php echo $lowercase; ?>Remove" action="addonAction.php" method="post">
								<input type="hidden" name="localFolderLocation" value="<?php echo $lowercase; ?>"> 
								<input type="hidden" name="repoName" value="<?php echo $repo; ?>">
								<input type="hidden" name="action" value="Removing">
							</form>
							<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Remove <?php echo $uppercase; ?></a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</body>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}

	function addonMonitorAction(idToSubmit)
	{
		document.getElementById(idToSubmit).submit();
	}
</script>