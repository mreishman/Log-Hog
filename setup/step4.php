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
require_once('setupProcessFile.php');

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}


if($setupProcess != "step4")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
	header('Location: ' . $url, true, 302);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
require_once('../core/php/loadVars.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<script src="../core/js/jquery.js"></script>
	<style type="text/css">
		#settingsMainVars .settingsHeader{
			display: none;
		}
		li .settingsHeader{
			display: block !important;
		}
		#widthForWatchListSection{
			width: 100% !important;
		}
		#menu a, .link, .linkSmall, .context-menu
		{
			background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
		}
	</style>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Step 4 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Would you also like to install Monitor?</p>
	<p style="padding: 10px;">Monitor is a htop like program that allows you to monitor system resources from the web.</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<?php if($counterSteps == 3): ?>
			<a onclick="updateStatus('finished');" class="link">No, Finish Setup</a>
		<?php else: ?>
			<a onclick="updateStatus('step5');" class="link">Yes, Download!</a>
		<?php endif; ?>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/settingsSave.php" method="post"></form>
<script type="text/javascript">

var retryCount = 0;

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//download Monitor from github
		downloadFile();
		
	}
	function updateStatus(status)
	{
		var urlForSend = './updateSetupStatus.php?format=json'
		var data = {status: status };
		$.ajax({
				  url: urlForSend,
				  dataType: 'json',
				  data: data,
				  type: 'POST',
		success: function(data)
		{
			if(status == "finished")
			{
				defaultSettings();
			}
			else
			{
				customSettings();
			}
	  	},
			});
		return false;
	}

	function downloadFile()
	{
		var urlForSend = 'core/php/performSettingsInstallUpdateAction.php?format=json'
		var data = {action: 'downloadFile', file: 'master',downloadFrom: 'monitor/archive/', downloadTo: '../../monitor.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('downloadMonitor', '../../monitor.zip');
			}
		});	
	}

	function unzipFile()
	{
		var urlForSend = 'core/php/performSettingsInstallUpdateAction.php?format=json'
		var data = {action: 'unzipFile', locationExtractTo: '../../monitor.zip', locationExtractFrom: '../../top/'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('unzipFile', '../../top/index.php');
			}
		});	
	}

	function removeZipFile()
	{
		var urlForSend = 'core/php/performSettingsInstallUpdateAction.php?format=json'
		var data = {action: 'removeZipFile', fileToUnlink: '../../monitor.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('removeZipFile', '../../monitor.zip',false);
			}
		});
	}

	function verifyFile(action, fileLocation,isThere = true)
	{
		var urlForSend = 'core/php/performSettingsInstallUpdateAction.php?format=json'
		var data = {action: 'verifyFileIsThere', fileLocation: fileLocation};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function()
			{
				//downloaded, extract
				retryCount = 0;
				if(action == 'downloadMonitor')
				{
					unzipFile();
				}
				if(action == 'unzipFile')
				{
					removeZipFile();
				}
				
			},
			failure: function()
			{
				//failed? try again?
				retryCount++;
				if(retryCount >= 3)
				{
					//stop trying, give up :c
					updateError();
				}
				else
				{
					if(action == 'downloadMonitor')
					{
						downloadFile();
					}
					else if(action == 'unzipFile')
					{
						unzipFile();
					}
					//run previous ajax
				}
			}
		});	
	}

	function updateError()
	{

	}

	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var fileArray = JSON.parse('<?php echo json_encode($config['watchList']) ?>');
	var countOfWatchList = <?php echo $i; ?>;
	var countOfAddedFiles = 0;
	var countOfClicks = 0;
	var locationInsert = "newRowLocationForWatchList";
	var logTrimType = "<?php echo $logTrimType; ?>";


</script>
<script src="../core/js/settingsMain.js"></script>
<?php readfile('../core/html/popup.html') ?>
</html>