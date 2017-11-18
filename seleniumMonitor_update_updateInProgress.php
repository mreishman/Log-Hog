<?php
require_once("../core/php/commonFunctions.php");
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php');
$cssVersion = rand(1, 999999);
?>
<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>


<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<h1 id="titleForUpdater" >An Update is in progress</h1>
		<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
			<a onclick="window.location.href = '../settings/update.php'">Back to seleniumMonitor</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress id="progressBar" value="<?php echo $updateProgress['percent'];?>" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px; padding: 5px;">
				<br>
				<p>
					An update is currently in progress... please wait for it to finish or try one of the following options:
				</p>
				<h2>
					Option 1:
				</h2>
				<p>
					If there is no progress in around <b><span id="counterDisplay">2 minutes</span></b>, this page will auto redirect to the updater page.
				</p>
				<h2>
					Option 2:
				</h2>
				<p>
					Click here to retry an update if previous update failed or was inturrepted: 
					<a class="link" onclick="window.location.href = '../settings/update.php'"  >
						Retry Update
					</a>
				</p>
				<h2>
					Option 3:
				</h2>
				<p>
					Click here to revert back to a previous version 
					<a class="link" onclick="window.location=href = '../restore/restore.php'" >
						Revert to a previous version
					</a>
				</p>
			</div>
			<p style="border-bottom: 1px solid white;"></p>
			<div class="settingsHeader">
			Log Info
			</div>
			<div id="innerSettingsText" class="settingsDiv" style="height: 75px; overflow-y: scroll;" >
				
			</div>
		</div>
	</div>
</div>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">

var counter = 0;	
var counterInt;
<?php echo "var currentPercent = ".$updateProgress['percent'].";";?>


$( document ).ready(function()
{
	counterInt = setInterval(checkIfChange, 3000);

});

function checkIfChange()
{
	var urlForSend = '../core/php/getPercentUpdate.php?format=json'
	var data = {};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data: data,
		type: 'POST',
		success: function(data)
		{
			document.getElementById('innerSettingsText').innerHTML = "<br> Current Percent: "+currentPercent+"% ("+counter+")"+document.getElementById('innerSettingsText').innerHTML;
		  	if(data == currentPercent)
		  	{
		  		counter++
		  		if(counter > 40)
		  		{
		  			window.location.href = '../settings/update.php';
		  		}
		  		else if(currentPercent == 100)
		  		{
		  			finishedUpdate();
		  			clearInterval(counterInt);
		  		}
		  		else
		  		{
		  			updateCounter();
		  		}
		  	}
		  	else
		  	{
		  		counter = 0;
		  		document.getElementById('progressBar').value = data;
		  		currentPercent = data;
		  		if(currentPercent == 100)
		  		{
		  			finishedUpdate();
		  			clearInterval(counterInt);
		  		}
		  		else
		  		{
		  			updateCounter();
		  		}
		  	}
		}
	});	
}

function updateCounter()
{
	var textToUpdateTo = "2 Minutes";
	var counterInner = counter;
	if(counterInner !== 0)
	{
		if(counter <= 20)
		{
			textToUpdateTo = "1 Minute ";
		}
		else
		{
			textToUpdateTo = "";
			counterInner -= 20;
		}
		if(counterInner !== 0)
		{
			textToUpdateTo += ((20-counterInner) * 3) + " Seconds";
		}
	}
	document.getElementById("counterDisplay").innerHTML = textToUpdateTo;
}

function finishedUpdate()
{
	document.getElementById("titleForUpdater").innerHTML = "Finished Update";
	document.getElementById("innerDisplayUpdate").innerHTML = "<a class='link' onclick='window.location.href = \"../settings/update.php\"'  >Back to seleniumMonitor</a> ";
}

</script>
</body>
</html>