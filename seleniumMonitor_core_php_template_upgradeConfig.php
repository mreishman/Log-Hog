<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../../../core/js/jquery.js"></script>
</head>
<body>
<?php
$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../../../core/conf/config.php');
require_once('../../../core/php/configStatic.php');
require_once('../../../core/php/loadVars.php');

$configVersion = 0;
if(isset($config['configVersion']))
{
	$configVersion = $config['configVersion'];
}
$configVersionToUpgradeTo = $defaultConfig['configVersion'];
$totalUpgradeScripts = floatval($configVersionToUpgradeTo) - floatval($configVersion);
?>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Running Upgrade Scripts for Config...</h1>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 350px; overflow: auto; max-height: 300px;">
			<table style="padding: 10px;">
				<tr>
					<td style="height: 50px;">
						<img id="runLoad" src="../../../core/img/loading.gif" height="30px;">
						<img id="runCheck" style="display: none;" src="../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Running upgrade script <span id="runCount">1</span> of <?php echo $totalUpgradeScripts;?>
					</td>	
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="verifyLoad" style="display: none;" src="../../../core/img/loading.gif" height="30px;">
						<img id="verifyCheck" style="display: none;" src="../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verifying upgrade script <span id="verifyCount">1</span> of <?php echo $totalUpgradeScripts;?>
					</td>
				</tr>
			</table>
			</div>
			<p style="border-bottom: 1px solid white;"></p>
		</div>
	</div>
</div>
</body>

<script src="../../../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript"> 
	var lock = false;
	var urlForSendMain0 = '../../../core/php/checkVersionOfConfig.php?format=json';
	var urlForSendMain = '../../../core/php/upgradeScript/upgradeConfig-';
	var urlForSendMain2 = '.php?format=json';
	<?php
	echo "var startVersion = ".$configVersion.";";
	echo "var endVersion = ".$configVersionToUpgradeTo.";";
	?>

	$( document ).ready(function()
	{
		if(endVersion > startVersion)
		{
			runScript(startVersion+1);
		}
		else
		{
			window.location.href = "../../../settings/whatsNew.php";
		}
	});

	function runScript(version)
	{
		document.getElementById('runLoad').style.display = "block";
		document.getElementById('runLoad').style.display = "none";
		document.getElementById('verifyLoad').style.display = "none";
		var urlForSend = urlForSendMain+version+urlForSendMain2;
		var dataSend = {version: version};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success: function(data)
			{
				verifyFile(data);
			},
			failure: function(data)
			{
				runScript(startVersion+1);
			}
		});
	}


	function verifyFile(version)
	{
		document.getElementById('runCheck').style.display = "block";
		document.getElementById('runLoad').style.display = "none";
		document.getElementById('verifyLoad').style.display = "block";
		verifyCount = 0;
		verifyFileTimer = setInterval(function(){verifyFilePoll(version);},2000);
	}

	function verifyFilePoll(version)
	{
		if(lock == false)
		{
			lock = true;
			var urlForSend = urlForSendMain0;
			var data = {version: version};
			(function(_data){
				$.ajax({
					url: urlForSend,
					dataType: 'json',
					data: data,
					type: 'POST',
					success: function(data)
					{
						verifyPostEnd(data, _data);
					},
					failure: function(data)
					{
						verifyPostEnd(data, _data);
					},
					complete: function()
					{
						lock = false;
					}
				});	
			}(data));
		}
	}

	function verifyPostEnd(verified, data)
	{
		if(verified == true)
		{
			clearInterval(verifyFileTimer);
			verifySucceded(data['lastAction']);
		}
		else
		{
			verifyCount++;
			if(verifyCount > 29)
			{
				clearInterval(verifyFileTimer);
				verifyFail(data['lastAction']);
			}
		}
	}

	function updateError()
	{
		document.getElementById('innerDisplayUpdate').innerHTML = "<p>An error occured while trying to download Monitor. </p>";
	}

	function verifyFail(action)
	{
		updateError();
	}

	function verifySucceded(action)
	{
		retryCount = 0;
		startVersion++;
		if(endVersion > startVersion)
		{
			runScript(startVersion+1);
		}
		else
		{
			finishedTmpUpdate();
		}
	}

	function finishedTmpUpdate()
	{
		document.getElementById('verifyCheck').style.display = "block";
		document.getElementById('verifyLoad').style.display = "none";
		window.location.href = "../../../settings/whatsNew.php";
	}

</script> 
</html>