var urlForSendMain0 = "themeChangeLogic.php?format=json";
var urlForSendMain1 = "themeChangeLogicVerify.php?format=json";
var verifyCountSuccessThemeChange = 0;
var verifyFileTimerThemeChange = null;
var lockThemeLogic = false;

function copyFilesThemeChange()
{
	var urlForSend = themeChangeLogicDirModifier+urlForSendMain0;
	var dataSend = {};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data: dataSend,
		type: 'POST',
		success(data)
		{
			verifyFileThemeChange(data);
		},
		failure(data)
		{
			verifyFileThemeChange(false);
		},
		complete(data){}
	});
}


function verifyFileThemeChange(version)
{
	document.getElementById('runCheck').style.display = "block";
	document.getElementById('runLoad').style.display = "none";
	document.getElementById('verifyLoad').style.display = "block";
	verifyCount = 0;
	verifyCountSuccessThemeChange = 0;
	verifyFileTimerThemeChange = setInterval(function(){verifyFilePollThemeChange(version);},2000);
}

function verifyFilePollThemeChange(version)
{
	if(lockThemeLogic === false)
	{
		lockThemeLogic = true;
		var urlForSend = themeChangeLogicDirModifier + urlForSendMain1;
		var data = {version: version};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: 'json',
				data,
				type: 'POST',
				success(data)
				{
					verifyPostEndThemeChange(data);
				},
				failure(data)
				{
					verifyPostEndThemeChange(data);
				},
				complete()
				{
					lockThemeLogic = false;
				}
			});	
		}(data));
	}
}

function verifyPostEndThemeChange(verified)
{
	if(verified == true)
	{
		verifyCountSuccessThemeChange++;
		if(verifyCountSuccessThemeChange >= successVerifyNum)
		{
			verifyCountSuccessThemeChange = 0;
			clearInterval(verifyFileTimerThemeChange);
			verifySuccededThemeChange();
		}
	}
	else
	{
		verifyCountSuccessThemeChange = 0;
		verifyCount++;
		if(verifyCount > 29)
		{
			clearInterval(verifyFileTimerThemeChange);
			verifyFailThemeChange();
		}
	}
}

function updateError()
{
	document.getElementById('innerDisplayUpdate').innerHTML = "<h1>An error occured while trying to copy over your selected theme. </h1>";
}

function verifyFailThemeChange()
{
	updateError();
}

function verifySuccededThemeChange()
{
	retryCount = 0;
	finishedTmpUpdate();
}

function finishedTmpUpdate()
{
	document.getElementById('verifyCheck').style.display = "block";
	document.getElementById('verifyLoad').style.display = "none";
	window.location.href = "<?php echo getCookieRedirect(); ?>";
}