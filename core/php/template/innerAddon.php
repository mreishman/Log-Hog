<span id="innerAddonSpanReplace">
	<?php
	$currentDir = "";
	if(!isset($addons))
	{
		require_once("../class/core.php");
		$core = new core();
		require_once($core->baseURL()."core/php/class/addons.php");
		$addons = new addons();
		require_once($core->baseURL()."core/php/class/sessions.php");
		$sessions = new sessions();
		$currentSelectedTheme = $session->returnCurrentSelectedTheme();
		$baseUrl = "../../../local/".$currentSelectedTheme."/";
		$localURL = $baseUrl;
		require_once($baseUrl.'conf/config.php');
		require_once('../../conf/config.php');
		require_once('../configStatic.php');
		$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir('../../../local/Themes/'.$currentTheme))
		{
			require_once('../../../local/Themes/'.$currentTheme."/defaultSetting.php");
		}
		else
		{
			require_once('../../Themes/'.$currentTheme."/defaultSetting.php");
		}
		require_once('../loadVars.php');
		$currentDir = "../../../";
	}

	//check if monitor is installed
	$monitorInfo = $addons->checkForMonitorInstall($locationForMonitor, "../../");
	$configStaticMonitor = null;

	if($monitorInfo["local"])
	{
		$configStaticMain = $configStatic;
		require_once($currentDir.'monitor/core/php/configStatic.php');
		$configStaticMonitor = $configStatic;
		$configStatic = $configStaticMain;
	}

	//check if search is installed
	$searchInfo = $addons->checkForSearchInstall($locationForSearch, "../../");
	$configStaticSearch = null;

	if($searchInfo["local"])
	{
		$configStaticMain = $configStatic;
		require_once($currentDir.'search/core/php/configStatic.php');
		$configStaticSearch = $configStatic;
		$configStatic = $configStaticMain;
	}

	//check if seleniumMonitor is installed
	$seleniumMonitorInfo = $addons->checkForSeleniumMonitorInstall($locationForSeleniumMonitor, "../../");
	$configStaticSeleniumMonitor = null;

	if($seleniumMonitorInfo["local"])
	{
		$configStaticMain = $configStatic;
		require_once($currentDir.'seleniumMonitor/core/php/configStatic.php');
		$configStaticSeleniumMonitor = $configStatic;
		$configStatic = $configStaticMain;
	}

	//check for status install
	$statusInfo = $addons->checkForStatusInstall($locationForStatus, "../../");
	$configStaticStatus = null;

	if($statusInfo["local"])
	{
		$configStaticMain = $configStatic;
		require_once($currentDir.'status/core/php/configStatic.php');
		$configStaticStatus = $configStatic;
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
			"ConfigStatic"	=>	$configStaticMonitor,
			"id"			=>	"menuMonitorAddon"
		),
		"Search" => array(
			"Installed"		=> 	$searchInfo["loc"],
			"Local"			=>	$searchInfo["local"],
			"lowercase"		=>	"search",
			"uppercase"		=>	"Search",
			"Repo"			=>	"Search",
			"Description"	=> 	"A simple visual grep tool that is intended for use on dev boxes.",
			"ConfigStatic"	=>	$configStaticSearch,
			"id"			=>	"menuSearchAddon"
		),
		"seleniumMonitor" => array(
			"Installed"		=> 	$seleniumMonitorInfo["loc"],
			"Local"			=>	$seleniumMonitorInfo["local"],
			"lowercase"		=>	"seleniumMonitor",
			"uppercase"		=>	"SeleniumMonitor",
			"Repo"			=>	"SeleniumMonitor",
			"Description"	=> 	"A php based web monitor for selenium grids / an easy way to run tests",
			"ConfigStatic"	=>	$configStaticSeleniumMonitor,
			"id"			=>	"menuSeleniumMonitorAddon"
		),
		"status"		=> array(
			"Installed"		=> 	$statusInfo["loc"],
			"Local"			=>	$statusInfo["local"],
			"lowercase"		=>	"status",
			"uppercase"		=>	"Status",
			"Repo"			=>	"gitStatus",
			"Description"	=> 	"A php based web monitor for repo git status",
			"ConfigStatic"	=>	$configStaticStatus,
			"id"			=>	"menuStatusAddon"
		)
	);

	?>
	<script type="text/javascript">
		var listOfAddons = <?php echo json_encode($listOfAddons); ?>;
	</script>
	<table style="width: 100%;">
		<tr>
			<td width="10%">
			</td>
			<td width="25%">
			</td>
			<td width="15%">
			</td>
			<td width="15%">
			</td>
			<td width="15%">
			</td>
			<td width="15%">
			</td>
			<td width="5%">
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
					<form id="<?php echo $lowercase; ?>UpdateForm" action="<?php echo $lowercase; ?>/update/updater.php" method="post" ></form>
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
						<?php if(strpos($URI, 'step') === false): ?>
							<td>
								<span class="<?php echo $lowercase; ?>RemoveHideThis" >
									<?php if ($value['ConfigStatic']['version'] !== $value['ConfigStatic']['newestVersion']): ?>
										Update Available - <?php echo $value['ConfigStatic']['newestVersion']; ?>
									<?php else: ?>
										No Update
									<?php endif; ?>
								</span>
							</td>
							<td>
								<span class="<?php echo $lowercase; ?>RemoveHideThis" >
									<?php if ($value['ConfigStatic']['version'] !== $value['ConfigStatic']['newestVersion']): ?>
										<a class="link" onclick="installUpdates('<?php echo $lowercase; ?>/','<?php echo $lowercase; ?>UpdateForm');">Install <?php echo $value['ConfigStatic']["newestVersion"];?> Update</a>
									<?php else: ?>
										<a onclick="checkForUpdates('<?php echo $lowercase; ?>/','<?php echo $uppercase; ?>','<?php echo $value['ConfigStatic']['version'];?>','<?php echo $lowercase; ?>UpdateForm');" class="link">Check For Updates</a>
									<?php endif; ?>
								</span>
								<span class="<?php echo $lowercase; ?>RemoveShowThis" style="display: none;"  >
									Removing...
								</span>
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
							<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Remove</a>
						</td>
						<td>
							<a target="_blank" onclick="window.location.href= '<?php echo $installed; ?>'" class="link">View</a>
						</td>
					<?php else: ?>
						<td colspan="4">
							This is installed, but not within Log-Hog
						</td>
						<td>
							<a target="_blank" onclick="window.location.href= '<?php echo $installed; ?>'" class="link">View</a>
						</td>
					<?php endif; ?>
				<?php else: ?>
					<td colspan="4">
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
						<a onclick="addonMonitorAction(<?php echo $key; ?>);" class="link">Download</a>
					</td>
				<?php endif; ?>
			</tr>
			<tr style="height: 10px;">
				<td colspan="7">
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="7">
				<?php echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					array(
						"style"			=>	"margin-bottom: -4px;",
						"height"		=>	"20px",
						"class"			=>	"mainMenuImage",
						"srcModifier"	=>	"",
						"data-src"		=>	$arrayOfImages["info"]
					)
				); ?>
	  			<i>Make sure you have run through setup before trying to update</i>
			</td>
		</tr>
	</table>
</span>