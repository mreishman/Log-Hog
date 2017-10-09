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
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php');
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
			<a onclick="window.location.href = '../settings/update.php'">Back to Log-Hog</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress id="progressBar" value="<?php echo $updateProgress['percent'];?>" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px; padding: 5px;">
			<br>
			An update is currently in progress... please wait for it to finish. <br><br> If there is no progress in around 2 minutes, this page will auto redirect to the updater page. <br><br> You can also click here to redirect to this page if a previous update failed to retry the update: <a class="link" onclick="window.location.href = '../settings/update.php'"  >Retry Update</a> <br><br> or here to revert back to a previous version <a class="link" onclick="window.location=href = '../restore/restore.php'" > Revert to a previous version </a>
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
		  	}
		}
	});	
}

function finishedUpdate()
{
	document.getElementById("titleForUpdater").innerHTML = "Finished Update";
	document.getElementById("innerDisplayUpdate").innerHTML = "<a class='link' onclick='window.location.href = \"../settings/update.php\"'  >Back to Log-Hog</a> ";
}

</script>
</body>
</html>