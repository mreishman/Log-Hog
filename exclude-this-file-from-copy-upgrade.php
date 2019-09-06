<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../../core/template/base.css">
	<link rel="stylesheet" type="text/css" href="../../../../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../../../../core/template/upgrade.css">
	<?php require_once("../../../../core/php/customCSS.php"); ?>
	<link rel="icon" type="image/png" href="../../../../core/img/favicon.png" />
	<script type="text/javascript" src="../../../../core/js/jquery.js" />
</head>
<body>
<div id="upgradeStatusPopup">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Updating Update Actions File</h1>
		</span>
		<progress id="checkProgress" value="0" max="4"></progress>
		<progress id="allProgress" value="0" max="100"></progress>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<div id="innerDisplayUpdate">
			<table style="padding: 10px; height: 100%;">
				<tr>
					<td style="height: 40px;">
						<img id="step1" src="../../../../core/img/loading.gif" height="30px;">
						<img id="step1Check" style="display: none;" src="../../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verify File Copied <!-- Verify file action -->
					</td>
				</tr>
				<tr>
					<td style="height: 40px;">
						<img id="step2" style="display: none;" src="../../../../core/img/loading.gif" height="30px;">
						<img id="step2Check" style="display: none;" src="../../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Removing Old Updater Action File <!--Remove file actoin -->
					</td>
				</tr>
				<tr>
					<td style="height: 40px;">
						<img id="step3"  style="display: none;" src="../../../../core/img/loading.gif" height="30px;">
						<img id="step3Check" style="display: none;" src="../../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verify File Removed <!-- Verify file action -->
					</td>
				</tr>
				<tr>
					<td style="height: 40px;">
						<img id="step4"  style="display: none;" src="../../../../core/img/loading.gif" height="30px;">
						<img id="step4Check" style="display: none;" src="../../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Renaming Tmp File <!-- Rename action -->
					</td>
				</tr>
				<tr>
					<td style="height: 40px;">
						<img id="step5"  style="display: none;" src="../../../../core/img/loading.gif" height="30px;">
						<img id="step5Check" style="display: none;" src="../../../../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verify New File <!-- Verify file action -->
					</td>
				</tr>
			</table>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	var lock = false;
	var verifyCount = 0;
	var verifyCountSuccess = 0;
	var successVerifyNum = 4;
	var maxcount = 100;
	var verifyFileTimer = null;
	var action = 1;
	var boolCheck = true;
	$( document ).ready(function()
	{
		$("body").height(""+window.innerHeight+"px");
		start();
	});
	$( window ).resize(function() {
		$("body").height(""+window.innerHeight+"px");
	});
	function updateProgress(verifyCountLocal,verifyCountSuccessLocal)
	{
		verifyCount = verifyCountLocal;
		verifyCountSuccess = verifyCountSuccessLocal;
		$("#checkProgress").value = verifyCountSuccessLocal;
		$("#checkAll").value = verifyCountLocal;
	}
	function start()
	{
		action = 1;
		boolCheck = true;
		updateProgress(0,0);
		verifyFileTimer = setInterval(function(){verifyFilePoll("../../../../core/php/performSettingsInstallUpdateActionTmp.php");},2000);
	}
	function verifyFilePoll(file)
	{
		let dataSend = {"file_name":file};
		$.ajax({
			url: "exclude-this-file-from-copy-verify.php",
			dataType: "json",
			data: dataSend,
			type: "POST",
			success(data)
			{
				let updateProgressBool = true;
				if(data == boolCheck)
				{
					verifyCountSuccess++;
					if(verifyCountSuccess >= successVerifyNum)
					{
						verifyCountSuccess = 0;
						clearInterval(verifyFileTimer);
						if(action === 1)
						{
							$("#step1").hide();
							$("#step1Check").show();
							$("#step2").show();
							stepTwo();
						}
						else if(action === 3)
						{
							$("#step3").hide();
							$("#step3Check").show();
							$("#step4").show();
							stepFour();
						}
						else if(action === 3)
						{
							$("#step5").hide();
							$("#step5Check").show();
							end();
						}
					}
				}
				else
				{
					verifyCountSuccess = 0;
					verifyCount++;
					if(verifyCount > maxcount)
					{
						updateProgressBool = false;
						clearInterval(verifyFileTimer);
						//ERROR
					}
				}
				if(updateProgressBool)
				{
					updateProgress(verifyCount,verifyCountSuccess);
				}
			}
		});
	}
	function stepTwo()
	{
		$.ajax({
			url: "exclude-this-file-from-copy-remove.php",
			dataType: "json",
			data: dataSend,
			type: "POST",
			success(data)
			{
				$("#step2").hide();
				$("#step2Check").show();
				$("#step3").show();
				step3();
			}
		});
	}
	function step3()
	{
		action = 3;
		boolCheck = false;
		updateProgress(0,0);
		verifyFileTimer = setInterval(function(){verifyFilePoll("../../../../core/php/performSettingsInstallUpdateAction.php");},2000);
	}
	function stepFour()
	{
		$.ajax({
			url: "exclude-this-file-from-copy-rename.php",
			dataType: "json",
			data: dataSend,
			type: "POST",
			success(data)
			{
				$("#step4").hide();
				$("#step4Check").show();
				$("#step5").show();
				step5();
			}
		});
	}
	function step5()
	{
		action = 5;
		boolCheck = true;
		updateProgress(0,0);
		verifyFileTimer = setInterval(function(){verifyFilePoll("../../../../core/php/performSettingsInstallUpdateAction.php");},2000);
	}
	function end()
	{
		window.location.href = "../../../Updater.php";
	}
</script>
</html>