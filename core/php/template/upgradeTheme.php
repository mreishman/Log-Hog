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

?>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Copying over Theme files to local/<?php echo $currentSelectedTheme; ?>/theme...</h1>
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
						Copying Images / CSS
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
						Verifying Copied files
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
	var urlForSendMain0 = '../themeChangeLogic.php?format=json';
	var urlForSendMain1 = '../themeChangeLogicVerify.php?format=json';

	$( document ).ready(function()
	{
		copyFiles();
	});

	function copyFiles()
	{
		console.log("Copy Files");
		var urlForSend = urlForSendMain0;
		var dataSend = {};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success(data)
			{
				console.log(data);
				verifyFile(data);
			},
			failure(data)
			{
				verifyFile(false);
			},
			complete(data)
			{
				console.log("Finished?");
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
		if(lock === false)
		{
			lock = true;
			var urlForSend = urlForSendMain1;
			var data = {version: version};
			(function(_data){
				$.ajax({
					url: urlForSend,
					dataType: 'json',
					data,
					type: 'POST',
					success(data)
					{
						verifyPostEnd(data);
					},
					failure(data)
					{
						verifyPostEnd(data);
					},
					complete()
					{
						lock = false;
					}
				});	
			}(data));
		}
	}

	function verifyPostEnd(verified)
	{
		if(verified == true)
		{
			clearInterval(verifyFileTimer);
			verifySucceded();
		}
		else
		{
			verifyCount++;
			if(verifyCount > 29)
			{
				clearInterval(verifyFileTimer);
				verifyFail();
			}
		}
	}

	function updateError()
	{
		document.getElementById('innerDisplayUpdate').innerHTML = "<p>An error occured while trying to copy over your selected theme. </p>";
	}

	function verifyFail()
	{
		updateError();
	}

	function verifySucceded()
	{
		retryCount = 0;
		finishedTmpUpdate();
	}

	function finishedTmpUpdate()
	{
		document.getElementById('verifyCheck').style.display = "block";
		document.getElementById('verifyLoad').style.display = "none";
		window.location.href = "../../../settings/themes.php";
	}

</script> 
</html>