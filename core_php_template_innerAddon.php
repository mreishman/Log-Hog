<?php

//check if monitor is installed
$monitorInfo = checkForMonitorInstall($locationForMonitor, "../../../");
$configStaticMonitor = null;

if($monitorInfo["local"])
{
	$configStaticMain = $configStatic;
	require_once('../monitor/core/php/configStatic.php');
	$configStaticMonitor = $configStatic;
	$configStatic = $configStaticMain;
}

//check if search is installed
$searchInfo = checkForSearchInstall($locationForSearch, "../../../");
$configStaticSearch = null;

if($searchInfo["local"])
{
	$configStaticMain = $configStatic;
	require_once('../search/core/php/configStatic.php');
	$configStaticSearch = $configStatic;
	$configStatic = $configStaticMain;
}

//check if seleniumMonitor is installed
$seleniumMonitorInfo = checkForSeleniumMonitorInstall($locationForSeleniumMonitor, "../../../");
$configStaticSeleniumMonitor = null;

if($seleniumMonitorInfo["local"])
{
	$configStaticMain = $configStatic;
	require_once('../seleniumMonitor/core/php/configStatic.php');
	$configStaticSeleniumMonitor = $configStatic;
	$configStatic = $configStaticMain;
}


$listOfAddons = array(
	"Monitor" => array(
		"Installed"		=> 	$monitorInfo["loc"],
		"Local"			=>	$monitorInfo["local"],
		"lowercase"		=>	"monitor",
		"uppercase"		=>	"Monitor",
		"Repo"			=>	"Monitor",
		"Description"	=> 	"A simple php server monitoring tool.",
		"ConfigStatic"	=>	$configStaticMonitor
	),
	"Search" => array(
		"Installed"		=> 	$searchInfo["loc"],
		"Local"			=>	$searchInfo["local"],
		"lowercase"		=>	"search",
		"uppercase"		=>	"Search",
		"Repo"			=>	"Search",
		"Description"	=> 	"A simple visual grep tool that is intended for use on dev boxes.",
		"ConfigStatic"	=>	$configStaticSearch
	),
	"seleniumMonitor" => array(
		"Installed"		=> 	$seleniumMonitorInfo["loc"],
		"Local"			=>	$seleniumMonitorInfo["local"],
		"lowercase"		=>	"seleniumMonitor",
		"uppercase"		=>	"SeleniumMonitor",
		"Repo"			=>	"SeleniumMonitor",
		"Description"	=> 	"A php based web monitor for selenium grids / an easy way to run tests",
		"ConfigStatic"	=>	$configStaticSeleniumMonitor
	)
);

?>

<script src="../core/js/loghogDownloadJS.js"></script>
<table style="width: 100%;">
	<tr>
		<td width="15%">
		</td>
		<td width="25%">
		</td>
		<td width="15%">
		</td>
		<td width="15%">
		</td>
		<td width="15%">
		</td>
		<td width="10%">
		</td>
	</tr>
	<?php foreach ($listOfAddons as $key => $value):
	$lowercase = $value["lowercase"];
	$uppercase = $value["uppercase"];
	$repo = $value["Repo"];
	$installed = $value["Installed"];
	$localInstall = $value["Local"];
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
				<?php if($localInstall):?>
					<td>
						Version: <?php echo $value['ConfigStatic']['version'];?>
						<br>
						<progress id="<?php echo $lowercase; ?>RemoveProgressBar" style="width: 100%;" value="0" max="100"></progress>
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
						This is installed, but not within Log-Hog
					</td>
					<td>
						<a onclick="window.location.href= '<?php echo $installed; ?>'" class="link">View</a>
					</td>
				<?php endif; ?>
			<?php else: ?>
				<td colspan="3">
					<progress id="<?php echo $lowercase; ?>DownloadProgressBar" style="width: 100%;" value="0" max="100"></progress>
				</td>
				<td>
					<script type="text/javascript">
					var <?php echo $key; ?> = "<?php echo $lowercase; ?>Download"
					</script>
					<form id="<?php echo $lowercase; ?>Download">
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


<script type="text/javascript">

	var retryCount = 0;
	var verifyCount = 0;
	var lock = false;
	var directory = "../../top/";
	var urlForSendMain = "../core/php/performSettingsInstallUpdateAction.php?format=json";
	var action = "";
	var localFolderLocation = "";
	var repoName = "";
	var idToSubmitStatic = "";

	function addonMonitorAction(idToSubmit)
	{
		idToSubmitStatic = idToSubmit;
		var formData = $("#"+idToSubmit).serializeArray();
		var newObject = {};
		var keysInfo = Object.keys(formData);
		var keysInfoLength = keysInfo.length;
		for(var i = 0; i < keysInfoLength; i++)
		{
			newObject[formData[i]["name"]] = formData[i]["value"];
		}
		action = newObject["action"];
		localFolderLocation = newObject["localFolderLocation"];
		repoName = newObject["repoName"];
		if(action === "Downloading")
		{
			checkIfTopDirIsEmpty();
		}
		else
		{
			removeFilesFromToppFolder(true);
		}
	}

	function finishedDownload()
	{
		//reload page on finish?
		updateText(100);
		location.reload();
	}

	currentVersion = "";
</script>