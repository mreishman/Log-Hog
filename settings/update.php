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
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

$daysSince = calcuateDaysSince($configStatic['lastCheck']);
?>
<!doctype html>
<head>
	<title>Settings | Update</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	
	<div id="main">
		<div class="settingsHeader">
			Update
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Current Version - <?php echo $configStatic['version'];?></h2>
				</li>	
				<li>
					<h2>Last Check for updates -  <span id="spanNumOfDaysUpdateSince" ><?php echo $daysSince;?> Day<?php if($daysSince != 1){ echo "s";} ?></span> Ago</h2>
				</li>
				<li>
					<form id="settingsCheckForUpdate" style="float: left; padding: 10px;">
					<a class="link" onclick="checkForUpdates();">Check for updates</a>
					</form>
					<form id="settingsInstallUpdate" action="../update/updater.php" method="post" style="padding: 10px;">
					<?php
					if($levelOfUpdate != 0){echo '<a class="link" onclick="installUpdates();">Install '.$configStatic["newestVersion"].' Update</a>';}
					?>
					</form>
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage1" src="<?php echo $baseUrl;?>img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage2" src="<?php echo $baseUrl;?>yellowWarning.png" height="15px"> &nbsp; Minor Updates - <span id="minorUpdatesVersionNumber"><?php echo $configStatic['newestVersion'];?></span> - bug fixes </h2>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="<?php echo $baseUrl;?>redWarning.png" height="15px"> &nbsp; Major Updates - <span id="majorUpdatesVersionNumber"><?php echo $configStatic['newestVersion'];?></span> - new features!</h2>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="<?php echo $baseUrl;?>redWarning.png" height="15px"><img id="statusImage3" src="<?php echo $baseUrl;?>redWarning.png" height="15px"><img id="statusImage3" src="<?php echo $baseUrl;?>redWarning.png" height="15px"> &nbsp; Very Major Updates - <span id="veryMajorUpdatesVersionNumber"><?php echo $configStatic['newestVersion'];?></span> - a lot of new features!</h2>
				</li>
			</ul>
		</div>
		<div id="releaseNotesHeader" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsHeader">
			Update - Release Notes
		</div>
		<div id="releaseNotesBody" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsDiv" >
			<ul id="settingsUl">
			<?php
			if(array_key_exists('versionList', $configStatic))
			{
				foreach ($configStatic['versionList'] as $key => $value)
				{
					$version = explode('.', $configStatic['version']);
					$newestVersion = explode('.', $key);
					$levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);
					if($levelOfUpdate != 0)
					{
						echo "<li><h2>Changelog For ".$key." update</h2></li>";
						echo $value['releaseNotes'];
					}
				}
			}
			?>
			</ul>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script type="text/javascript">

	var timeoutVar;
	var dataFromJSON;
	var currentVersion = "<?php echo $configStatic['version']?>";

	function goToUrl(url)
	{
		window.location.href = url;
	}

	function checkForUpdates()
	{
		displayLoadingPopup();
		$.getJSON('../core/php/settingsCheckForUpdateAjax.php', {}, function(data) 
		{
			if(data.version == "1" || data.version == "2" | data.version == "3")
			{
				dataFromJSON = data;
				timeoutVar = setInterval(function(){checkForUpdateTimer();},3000);
			}
			else if (data.version == "0")
			{
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >No Update Needed</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
			}
			else
			{
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates. Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
			}
			
		});
	}

	function checkForUpdateTimer()
	{
		$.getJSON('../core/php/configStaticCheck.php', {}, function(data) 
		{
			if(currentVersion != data)
			{
				clearInterval(timeoutVar);
				showPopupForUpdate();
			}
		});
	}

	function showPopupForUpdate()
	{
		document.getElementById('noUpdate').style.display = "none";
		document.getElementById('minorUpdate').style.display = "none";
		document.getElementById('majorUpdate').style.display = "none";
		document.getElementById('NewXReleaseUpdate').style.display = "none";

		if(dataFromJSON.version == "1")
		{
			document.getElementById('minorUpdate').style.display = "block";
			document.getElementById('minorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
		}
		else if (dataFromJSON.version == "2")
		{
			document.getElementById('majorUpdate').style.display = "block";
			document.getElementById('majorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
		}
		else
		{
			document.getElementById('NewXReleaseUpdate').style.display = "block";
			document.getElementById('veryMajorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
		}


		document.getElementById('releaseNotesHeader').style.display = "block";
		document.getElementById('releaseNotesBody').style.display = "block";
		document.getElementById('releaseNotesBody').innerHTML = dataFromJSON.changeLog;
		document.getElementById('settingsInstallUpdate').innerHTML = '<a class="link" onclick="installUpdates();">Install '+dataFromJSON.versionNumber+' Update</a>';


		//Update needed
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >New Version Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+dataFromJSON.versionNumber+" is now available!</div><div class='link' onclick='installUpdates();' style='margin-left:74px; margin-right:50px;margin-top:25px;'>Update Now</div><div onclick='hidePopup();' class='link'>Maybe Later</div></div>";
	}

	function closePopupNoUpdate()
	{
		document.getElementById("spanNumOfDaysUpdateSince").innerHTML = "0 Days";
		hidePopup();
	}

	function installUpdates()
	{
		displayLoadingPopup();
		//reset vars in post request
		var urlForSend = '../core/php/resetUpdateFilesToDefault.php?format=json'
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function(data)
			{
				//set thing to check for updated files. 	
				timeoutVar = setInterval(function(){verifyChange();},3000);
		  	}
		});
	}

	function verifyChange()
	{
		var urlForSend = '../update/updateActionCheck.php?format=json'
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data == 'finishedUpdate')
				{
					clearInterval(timeoutVar);
					actuallyInstallUpdates();
				}
		  	}
		});
	}

	function actuallyInstallUpdates()
	{
		$("#settingsInstallUpdate").submit();
	}
</script>