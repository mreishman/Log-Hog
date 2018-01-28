<?php
require_once('core/php/errorCheckFunctions.php');
$currentPage = "index.php";
checkIfFilesExist(
	array("core/conf/config.php","core/php/configStatic.php","core/php/loadVars.php","core/php/updateCheck.php","core/js/jquery.js","core/template/loading-bar.css","core/js/loading-bar.min.js","core/php/customCSS.php","core/php/template/popup.php","core/js/main.js","core/js/rightClickJS.js","core/js/update.js","core/php/commonFunctions.php","local/layout.php","setup/setupProcessFile.php","error.php"),
	 "",
	 $currentPage);
checkIfFilesAreReadable(
	array("core/conf/config.php","core/php/configStatic.php","core/php/loadVars.php","core/php/updateCheck.php","core/js/jquery.js","core/template/loading-bar.css","core/js/loading-bar.min.js","core/php/customCSS.php","core/php/template/popup.php","core/js/main.js","core/js/rightClickJS.js","core/js/update.js","core/php/commonFunctions.php","local/layout.php","setup/setupProcessFile.php","error.php"),
	 "",
	 $currentPage);
require_once('core/php/commonFunctions.php');

setCookieRedirect();
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

if(!file_exists($baseUrl.'conf/config.php'))
{
	require_once("setup/setupProcessFile.php");
	if($setupProcess !== "finished")
	{
		if($setupProcess === 'preStart')
		{
			$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
			if(strpos($partOfUrl, "index.php") !== false)
			{
				$partOfUrl = str_replace("index.php", "", $partOfUrl);
			}
			$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
			header('Location: ' . $url, true, 302);
			exit();
		}
		else
		{
			//setup either errored out, or was incomplete. throw error. 
			//throwSetupError("");
		}
	}
}
require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('core/php/configStatic.php');
require_once('core/php/loadVars.php');
require_once('core/php/updateCheck.php');

$daysSince = calcuateDaysSince($configStatic['lastCheck']);

if($pollingRateType == 'Seconds')
{
	$pollingRate *= 1000;
}
if($backgroundPollingRateType == 'Seconds')
{
	$backgroundPollingRate *= 1000;
}

$locationForStatusIndex = "";
if($locationForStatus != "")
{
	$locationForStatusIndex = $locationForStatus;
}
elseif (is_dir("../status"))
{
	$locationForStatusIndex = "../status/";
}
elseif (is_dir("../Status"))
{
	$locationForStatusIndex = "../Status/";
}

$locationForMonitorIndex = "";
if($locationForMonitor != "")
{
	$locationForMonitorIndex = $locationForMonitor;
}
elseif(is_file("monitor/index.php"))
{
	$locationForMonitorIndex = './monitor/';
}
elseif (is_dir("../monitor"))
{
	$locationForMonitorIndex = "../monitor/";
}
elseif (is_dir("../Monitor"))
{
	$locationForMonitorIndex = "../Monitor/";
}

$locationForSearchIndex = "";
if($locationForSearch != "")
{
	$locationForSearchIndex = $locationForSearch;
}
elseif(is_file("search/index.php"))
{
	$locationForSearchIndex = './search/';
}
elseif (is_dir("../search"))
{
	$locationForSearchIndex = "../search/";
}
elseif (is_dir("../Search"))
{
	$locationForSearchIndex = "../Search/";
}


$locationForSeleniumMonitorIndex = "";
if($locationForSeleniumMonitor != "")
{
	$locationForSeleniumMonitorIndex = $locationForSeleniumMonitor;
}
elseif(is_file("seleniumMonitor/index.php"))
{
	$locationForSeleniumMonitorIndex = './seleniumMonitor/';
}
elseif (is_dir("../seleniumMonitor"))
{
	$locationForSeleniumMonitorIndex = "../seleniumMonitor/";
}
elseif (is_dir("../SeleniumMonitor"))
{
	$locationForSeleniumMonitorIndex = "../SeleniumMonitor/";
}

$loadingBarStyle = "";

$loadingBarDefaultWidth = "data-stroke-width=\"3\" data-stroke-trail-width=\"3\"";

if($loadingBarVersion === 1)
{
	$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"green\" data-stroke-trail=\"darkGreen\" ".$loadingBarDefaultWidth;
}
elseif($loadingBarVersion === 2)
{
	$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"data:ldbar/res,stripe(#fff,#4fb3f0,1)\" data-stroke-trail=\"#082a36\" data-pattern-size=\"10\" ".$loadingBarDefaultWidth;
}
elseif($loadingBarVersion === 3)
{
	$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"data:ldbar/res,gradient(0,1,#3E8486,#A5F1F1)\" data-stroke-trail=\"#082a36\" ".$loadingBarDefaultWidth;
}
elseif($loadingBarVersion === 4)
{
	$loadingBarStyle = "data-type=\"stroke\"  data-stroke=\"data:ldbar/res,bubble(#248,#fff,50,1)\" data-stroke-trail=\"#082a36\" data-pattern-size=\"10\" ".$loadingBarDefaultWidth;
}
elseif($loadingBarVersion === 5)
{
	$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"green\" data-stroke-trail=\"#063305\" "."data-stroke-width=\"3\" data-stroke-trail-width=\"1\"";
}


$windowDisplayConfig = explode("x", $windowConfig);
$logDisplayArray = "{";
$logDisplay = "";
$borderPadding = 0;
for ($i=0; $i < $windowDisplayConfig[0]; $i++)
{
	$logDisplay .= "<tr>";
	$infoImageForWindowTableLoop = generateImage(
		$arrayOfImages["infoSideBar"],
		$imageConfig = array(
			"height"	=>	"20px",
			"style"		=>	"margin: 5px;",
			"title"		=>	"More Info"
			)
		);
	$clearImageForWindowTableLoop = generateImage(
		$arrayOfImages["eraserSideBar"],
		$imageConfig = array(
			"height"	=>	"20px",
			"style"		=>	"margin: 5px;",
			"title"		=>	"Clear Log"
			)
		);
	$deleteImageForWindowTableLoop =  generateImage(
		$arrayOfImages["trashCanSideBar"],
		$imageConfig = array(
			"height"	=>	"20px",
			"style"		=>	"margin: 5px;",
			"title"		=>	"Delete Log"
			)
		);
	for ($j=0; $j < $windowDisplayConfig[1]; $j++)
	{
		$borderPadding += 2;
		$counter = $j+($i*$windowDisplayConfig[1]);
		$logDisplay .= "<td style=\"vertical-align: top; padding: 0; border: 1px solid white;\" onclick=\"changeCurrentSelectWindow(".$counter.")\" class=\"logTdWidth\" >";
		$logDisplay .= "<table style=\"margin: 0px;padding: 0px; border-spacing: 0px; width:100%;\" ><tr><td style=\"padding: 0;";
		if($bottomBarIndexShow == 'false')
		{
			$logDisplay .= " width: 0; ";
		}
		else
		{
			$logDisplay .= " width: 30px; ";
		}
		$logDisplay .=  " \" >";
		$logDisplay .= "<div class=\"backgroundForSideBarMenu\" style=\"";
		if($bottomBarIndexShow == 'false')
		{
			$logDisplay .= "display: none; width: 0; ";
		}
		else
		{
			$logDisplay .= "display: inline; width: 30px; ";
		}
		$logDisplay .= " float: left; padding: 0px; \" id=\"titleContainer".$counter."\">";
		$logDisplay .= "<div class=\"popupForInfo\" style=\"display: none;\" id=\"title".$counter."\"></div>";
		$logDisplay .= "<p id=\"numSelectIndecatorForWindow".$counter."\"  class=\" ";
		if($counter === 0)
		{
			$logDisplay .= "currentWindowNumSelected";
		}
		else
		{
			$logDisplay .= "sidebarCurrentWindowNum";
		}
		$logDisplay .= " \" >".($counter+1)."</p>";
		$logDisplay .= "<a onclick=\"showInfo('".$counter."');\" style=\"cursor: pointer;\" >";
		$logDisplay .= $infoImageForWindowTableLoop;
		$logDisplay .= "</a>";
		$logDisplay .= "<a onclick=\"clearLog('".$counter."');\" style=\"cursor: pointer;\" >";
		$logDisplay .= $clearImageForWindowTableLoop;
		$logDisplay .= "</a>";
		$logDisplay .= "<a onclick=\"deleteLogPopup('".$counter."');\" style=\"cursor: pointer;\" >"; 
		$logDisplay .= $deleteImageForWindowTableLoop;
		$logDisplay .= "</a>";
		$logDisplay .= "</div> ";
		$logDisplay .= "</td><td style=\"padding: 0;\" >";
		$logDisplay .= " <span id=\"log".$counter."Td\"  class=\"logTrHeight\" style=\"overflow: auto; display: block; word-break: break-all;\" > <div style=\"padding: 0; white-space: pre-wrap;\" id=\"log".$counter."\" class=\"log\"  ></div> </span>";
		$logDisplay .= "</td></tr></table>";
		$logDisplay .= "</td>";
		$logDisplayArray .= " ".$counter.": null,";
	}
	$logDisplay .= "</tr>";
}
$logDisplayArray = rtrim($logDisplayArray, ",")."}";

?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
		echo loadVisibilityJS(baseURL());
	?>
	<link rel="stylesheet" type="text/css" href="core/template/loading-bar.css"/>
	<script type="text/javascript" src="core/js/loading-bar.min.js"></script>
</head>
<body>
	<?php require_once("core/php/customCSS.php");
	if($enablePollTimeLogging != "false"): ?>
		<div id="loggTimerPollStyle" style="width: 100%;background-color: black;text-align: center; line-height: 200%;" ><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span> | <span id="loggSkipCount" >0</span>/<?php echo $pollForceTrue; ?> | <span id="loggAllCount" >0</span>/<?php echo $pollRefreshAll; ?></div>
	<?php endif; ?>
	<div class="backgroundForMenus" id="menu">
		<div id="menuButtons" style="display: block;">
			<div onclick="pausePollAction();" class="menuImageDiv">
				<?php
					$styleString = "display: inline-block;";
					if($pausePoll !== 'true')
					{
						$styleString = "display: none;";
					}
					echo generateImage(
					$arrayOfImages["play"],
					$imageConfig = array(
						"id"		=>	"playImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px",
						"style"		=>	$styleString
						)
					);

					$styleString = "display: inline-block;";
					if($pausePoll === 'true')
					{
						$styleString = "display: none;";
					}
					echo generateImage(
					$arrayOfImages["pause"],
					$imageConfig = array(
						"id"		=>	"pauseImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px",
						"style"		=>	$styleString
						)
					); 
				?>
			</div>
			<div onclick="refreshAction();" class="menuImageDiv">
				<?php
					echo generateImage(
					$arrayOfImages["refresh"],
					$imageConfig = array(
						"id"		=>	"refreshImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);

					echo generateImage(
					$arrayOfImages["loading"],
					$imageConfig = array(
						"id"		=>	"refreshingImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px",
						"style"		=>	"display: none;"
						)
					);
				?> 
			</div>
			<?php if($truncateLog == 'true'): ?>
				<div onclick="deleteAction();"  class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["eraserMulti"],
						$imageConfig = array(
							"id"		=>	"deleteImage",
							"class"		=>	"menuImage",
							"height"	=>	"30px"
							)
						); 
					?>
				</div>
			<?php else: ?>
				<div onclick="clearLog(currentSelectWindow);" class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["eraser"],
						$imageConfig = array(
							"id"		=>	"deleteImage",
							"class"		=>	"menuImage",
							"height"	=>	"30px"
							)
						); 
					?>
				</div>
			<?php endif; ?>
			<?php if($locationForMonitorIndex != ""): ?>
				<div onclick="window.location.href = '<?php echo $locationForMonitorIndex; ?>'"  class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["taskManager"],
						$imageConfig = array(
							"id"		=>	"taskmanagerImage",
							"class"		=>	"menuImage",
							"height"	=>	"30px"
							)
						); 
					?>
				</div>
			<?php endif; ?>
			<?php if($locationForSearchIndex != ""): ?>
				<div onclick="window.location.href = '<?php echo $locationForSearchIndex; ?>'"  class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["search"],
						$imageConfig = array(
							"id"		=>	"searchImage",
							"class"		=>	"menuImage",
							"height"	=>	"30px"
							)
						); 
					?>
				</div>
			<?php endif; ?>
			<?php if($locationForSeleniumMonitorIndex != ""): ?>
				<div onclick="window.location.href = '<?php echo $locationForSeleniumMonitorIndex; ?>'"  class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["seleniumMonitor"],
						$imageConfig = array(
							"id"		=>	"seleniumMonitorImage",
							"class"		=>	"menuImage",
							"height"	=>	"30px"
							)
						); 
					?>
				</div>
			<?php endif; ?>
			<div onclick="window.location.href = './settings/about.php'" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["info"],
					$imageConfig = array(
						"id"		=>	"aboutImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					); 
				?>
			</div>
			<div onclick="window.location.href = './settings/main.php';"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["gear"],
					$imageConfig = array(
						"id"		=>	"gear",
						"class"		=>	"menuImage",
						"height"	=>	"30px",
						"data-id"	=>	"1"
						)
					); 
				
				if($updateNotificationEnabled === "true")
				{
					if($levelOfUpdate == 1)
					{
						echo generateImage(
							$arrayOfImages["yellowWarning"],
							$imageConfig = array(
								"id"		=>	"updateImage",
								"class"		=>	"menuImage",
								"height"	=>	"15px",
								"style"		=>	"position: absolute;margin-left: 13px;margin-top: -34px;"
							)
						);
					}
					elseif($levelOfUpdate == 2 || $levelOfUpdate == 3)
					{
						echo generateImage(
							$arrayOfImages["redWarning"],
							$imageConfig = array(
								"id"		=>	"updateImage",
								"class"		=>	"menuImage",
								"height"	=>	"15px",
								"style"		=>	"position: absolute;margin-left: 13px;margin-top: -34px;"
							)
						);
					}
				}
				?>
			</div>
			<?php if ($locationForStatusIndex != ""):?>
				<div class="menuImage" style="display: inline-block; cursor: pointer;" onclick="window.location.href='<?php echo $locationForStatusIndex; ?>'" >
					gS
				</div>
			<?php endif; ?>
			<div  id="clearNotificationsImage" style="display: none;" onclick="clearNotifications();" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["notificationClear"],
					$imageConfig = array(
						"id"		=>	"notificationClearImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					); 
				?>
			</div>
			<div style="float: right;">
				<select id="searchType" disabled class="selectDiv" name="searchType" style="height: 30px;">
					<option <?php if ($filterDefault === "title"){echo "selected"; }?> value="title">Title</option>
					<option <?php if ($filterDefault === "content"){echo "selected"; }?> value="content">Content</option>
				</select>
				<input disabled id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>" style="height: 30px; width: 200px;">
			</div>
		</div>
	</div>
	
	<div id="main">
		<table id="log" style="display: none; margin: 0px;padding: 0px; border-spacing: 0px;" style="width: 100%;" >
			<?php echo $logDisplay; ?>
		</table>
		<div id="firstLoad" style="width: 100%; height: 100%;">
			<h1 id="progressBarMainInfo" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 100px; font-size: 150%;" >Loading...</h1>
			<div id="divForProgressBar" style="width: 80%; height: 100px; margin-left: auto; margin-right: auto; margin-top: -15px; margin-bottom: -15px;">
				<div <?php echo $loadingBarStyle; ?> class="ldBar label-center" id="progressBar" data-value="0" style="width: 100%; height: 100%; margin: auto;"></div>
			</div>
			<h3 id="progressBarSubInfo" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 10px; font-size: 150%;" >Loading Javascript</h3>
		</div>
		<div id="noLogToDisplay" class='errorMessageLog errorMessageGreenBG' style="display: none; margin-top: 2%;" > There are currently no logs to display. </div>
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a title="{{title}}" class="{{id}}Button {{class}} index" onclick="show(this, '{{id}}')">
				<span class="currentWindowNum" id="{{id}}CurrentWindow"></span>
				{{title}}
				<span id="{{id}}Count" class="menuCounter"></span>
				<span id="{{id}}CountHidden" style="display: none;"></span>
			</a>
		</div>
	</div>
	<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
	<script>

		<?php
		if($rightClickMenuEnable == "true"): ?>
			var Rightclick_ID_list = [];
			if(document.getElementById('gear'))
			{
				Rightclick_ID_list.push('gear');
			}
			if(document.getElementById('aboutImage'))
			{
				Rightclick_ID_list.push('aboutImage');
			}
			if(document.getElementById('deleteImage'))
			{
				Rightclick_ID_list.push('deleteImage');
			}
			<?php
			if($levelOfUpdate == 1 || $levelOfUpdate == 2 || $levelOfUpdate == 3)
			{
				echo "Rightclick_ID_list.push('updateImage');";
			}
		endif;
		echo "var colorArrayLength = ".count($currentSelectedThemeColorValues).";";
		echo "var pausePollOnNotFocus = ".$pauseOnNotFocus.";";
		echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
		echo "var flashTitleUpdateLog = ".$flashTitleUpdateLog.";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		echo "var pollingRate = ".$pollingRate.";";
		echo "var backgroundPollingRate = ".$backgroundPollingRate.";";
		echo "var pausePollFromFile = ".$pausePoll.";";
		echo "var groupByColorEnabled = ".$groupByColorEnabled.";";
		echo "var pollForceTrue = ".$pollForceTrue.";";
		echo "var pollRefreshAll = ".$pollRefreshAll.";";
		echo "var sliceSize = ".$sliceSize.";";
		echo "var filterContentLinePadding = ".$filterContentLinePadding.";";
		echo "var logDisplayArray = ".$logDisplayArray.";";
		echo "var windowDisplayConfigRowCount = ".$windowDisplayConfig[0].";";
		echo "var windowDisplayConfigColCount = ".$windowDisplayConfig[1].";";
		echo "var borderPadding = ".$borderPadding.";"; 
		?>
		var dontNotifyVersion = "<?php echo $dontNotifyVersion;?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var enablePollTimeLogging = "<?php echo $enablePollTimeLogging;?>";
		var enableLogging = "<?php echo $enableLogging; ?>";
		var groupByType = "<?php echo $groupByType; ?>";
		var hideEmptyLog = "<?php echo $hideEmptyLog; ?>";
		var currentFolderColorTheme = "<?php echo $currentFolderColorTheme; ?>";
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray); ?>');
		var updateNoticeMeter = "<?php echo $updateNoticeMeter;?>";
		var pollRefreshAllBool = "<?php echo $pollRefreshAllBool;?>";
		var pollForceTrueBool = "<?php echo $pollRefreshAllBool;?>";
		var baseUrl = "<?php echo $baseUrl;?>";
		var updateFromID = "settingsInstallUpdate";
		var notificationCountVisible = "<?php echo $notificationCountVisible;?>";
		var caseInsensitiveSearch = "<?php echo $caseInsensitiveSearch; ?>";
		var filterContentHighlight = "<?php echo $filterContentHighlight; ?>";
		var filterContentLimit = "<?php echo $filterContentLimit; ?>";
		var scrollOnUpdate = "<?php echo $scrollOnUpdate; ?>";
	</script>
	<?php require_once('core/php/template/popup.php') ?>
	<script src="core/js/main.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/rightClickJS.js?v=<?php echo $cssVersion?>"></script>	
	<script src="core/js/update.js?v=<?php echo $cssVersion?>"></script>
	<nav id="context-menu" class="context-menu">
	  <ul id="context-menu-items" class="context-menu__items">
	  </ul>
	</nav>


</body>