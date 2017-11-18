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
if(!file_exists($baseUrl.'conf/config.php'))
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 302);
	exit();
}
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

$daysSince = calcuateDaysSince($configStatic['lastCheck']);

if($pollingRateType == 'Seconds')
{
	$pollingRate *= 1000;
}

?>
<!doctype html>
<head>
	<title>SeleniumMonitor | Run</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="../core/template/runcss.css?v=<?php echo $cssVersion; ?>">
	<script src="../core/js/jquery.js"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
	?>
</head>
<body>
	<?php require_once("../core/php/customCSS.php");?>
	<div id="menu">
		<a href="../view/">View</a>
		<a class="active">Run</a>
		<a href="../settings/"> Settings </a>
		<div onclick="pausePollAction();" class="menuImageDiv">
			<img id="playImage" class="menuImage" src="<?php echo $baseUrl; ?>img/Play.png" style="display: none;" height="30px">
			<img id="pauseImage" class="menuImage" src="<?php echo $baseUrl; ?>img/Pause.png" style="display: inline-block;" height="30px">
		</div>
		<img class="menuImage" src="<?php echo $baseUrl; ?>img/stopSignLight.png" onclick="stopAllTests();" style="display: inline-block; cursor: pointer;" height="30px">
		<?php require_once("../core/php/template/otherLinks.php");?>
	</div>

	<div id="main">
		
	</div>
	
	<div id="storage">
		<div class="newTestPopup">
			<div id="{{id}}" class="runNewTest">
				<div class="bannerPHP" style="display: none;">
					PhpUnit id not detected. Please verify that PhpUnit is installed and configured. 
				</div>
				<div class="newTestPartOne testSelectPartBorder testSelectPart">
					<h1 class="title">1.</h1>
					<br>
					<?php if(is_dir($locationOfTests) && !isDirRmpty($locationOfTests)):?>
						<select id="fileListSelector" onchange="getFileList();">
							<option value="PLACEHOLDER">Select A File</option>
							<?php
							$files = array_diff(scandir($locationOfTests), array('..', '.'));
							foreach($files as $key => $value)
							{
								$path = realpath($locationOfTests.DIRECTORY_SEPARATOR.$value);
						        if(!is_dir($path))
						        {
						        	echo "<option value='".$path."'' >".$value."</option>";
						        }
							}?>
						</select>
					<?php else: ?>
						Please specifiy a directory of where test are located on the settings page
					<?php endif;?>
				</div>
				<div class="newTestPartTwo testSelectPart testSelectPartBorder">
					<h1 class="title">2.</h1>
					<br>
					Set Base URL
					<br>
					<input id="baseUrlInput" type="text" placeholder="https://test.website.com/" name="baseUrl">
					<!--
					<br>
					<button onclick="changeBaseUrl('{{id}}BaseUrl')">Set Base Url</button>
					-->
				</div>
				<div class="newTestPartFour testSelectPart">
					<h1 class="title">3.</h1>
					<br>
					Max number of concurrent tests:
					<br>
					{{maxTestsNum}}
				</div>
				<br>
				<div class="newTestPartFive">
					<h1 class="title">4.</h1>
					<br>
					<div class="partFiveContainer">
						<span>Groups:</span>
						<br>
						<div id="groupsPlaceHodler">
						</div>
					</div>
					<div class="partFiveContainer">
						<span>Exclude Groups: </span>
						<br>
						<div id="groupExcludePlaceHolder">
						</div>
					</div>
					<div class="partFiveContainer">
						<span>Tests to be run<b>(<span id="testCount"></span>)</b>: </span>
						<br>
						<div id="testsPlaceHolder">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div style="background-color: white; border: 1px solid black; " id="{{id}}" class="scanBar containerMain">
				<div>
					<progress style="color: white; background: #000000; width: 100%;" id="{{id}}ProgressStart" value="0" max="1"></progress>
				</div>
				<div>
					<progress style="color: white; background: #000000; width: 100%;" id="{{id}}Progress" value="0" max="1"></progress>
				</div>
				<div  class="fontChange" style="width: 100%; text-align: left;" id="{{id}}Title">
					<h3>
						<span id="{{id}}Folder">{{file}}</span>
						<span id="{{id}}ProgressTxt" >--</span>
						<div style="float: right;">
							<img class="imageInHeaderContainer" onclick="deleteTests('{{id}}');" src="../core/img/trashCan.png">
							<img id="{{id}}StopButton" class="imageInHeaderContainer stopButtonClass" src="../core/img/stopSignDark.png" onclick="stopTestById('{{id}}');">
						</div>
					</h3>
				</div>
				<div id="{{id}}ProgressBlocks" class="containerBox">
					{{ProgressBlocks}}
				</div>
				<div class="key fontChange">
					Key:
					<br>
					<div class="block blockKey blockEmpty"></div> - Waiting
					<div class="block blockKey blockInProgress"></div> - Running
					<div class="block blockKey blockPass"></div> - Passed
					<div class="block blockKey blockError"></div> - Error
					<div class="block blockKey blockFail"></div> - Fail
					<div class="block blockKey blockSkip"></div> - Skipped
					<div class="block blockKey blockRisky"></div> - Risky
				</div>
				<div class="fontChange subTitleEF">
					(<span id="{{id}}FailCount">0</span>)Fails:
					<div style="float: right;">
						<img class="imageInHeaderContainer" id="{{id}}FailsContract" onclick="toggleSubtitleEF('{{id}}Fails');" src="../core/img/contract.png" style="display: none;">
						<img class="imageInHeaderContainer" id="{{id}}FailsExpand" onclick="toggleSubtitleEF('{{id}}Fails');" src="../core/img/expand.png" >
					</div>
				</div>
				<div class="containerBox containerMaxHeight">
					<span  style="display: none;" id="{{id}}Fails">
					</span>
				</div>
				<div  class="fontChange subTitleEF">
					(<span id="{{id}}ErrorCount">0</span>)Errors:
					<div style="float: right;">
						<img class="imageInHeaderContainer" id="{{id}}ErrorsContract" onclick="toggleSubtitleEF('{{id}}Errors');" src="../core/img/contract.png"  style="display: none;" >
						<img class="imageInHeaderContainer" id="{{id}}ErrorsExpand" onclick="toggleSubtitleEF('{{id}}Errors');" src="../core/img/expand.png">
					</div>
				</div>
				<div class="containerBox containerMaxHeight">
					<span style="display: none;" id="{{id}}Errors">
					</span>
				</div>
				<div class="fontChange">
					<input type="hidden" id="{{id}}File" value="{{file}}">
					<input type="text" id="{{id}}BaseUrl" value="{{baseUrl}}" disabled>
				</div>
			</div>
		</div>
	</div>
	
	<form id="settingsInstallUpdate" action="../update/updater.php" method="post" style="display: none"></form>
	<script src="../core/js/main.js?v=<?php echo $cssVersion?>"></script>
	<script src="../core/js/run.js?v=<?php echo $cssVersion?>"></script>
	<script>
		<?php
		echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		echo "var maxTestsStatic = ".$maxConcurrentTests.";";
		echo "var pollingRate = ".$pollingRate.";";
		?>
		var dontNotifyVersion = "<?php echo $dontNotifyVersion;?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray); ?>');
		var updateNoticeMeter = "<?php echo $updateNoticeMeter;?>";
		var baseUrl = "<?php echo $baseUrl;?>";

		$(document).ready(function()
		{
			resize();
			window.onresize = resize;

			showStartTestNewPopup();

			setInterval(function(){poll();},pollingRate);
		});
	</script>
	<?php readfile('../core/html/popup.html') ?>
</body>