var urlForSendMainThemeChange0 = "themeChangeLogic.php?format=json";
var urlForSendMainThemeChange1 = "themeChangeLogicVerify.php?format=json";
var verifyCountSuccessThemeChange = 0;
var verifyFileTimerThemeChange = null;
var lockThemeLogic = false;

function copyFilesThemeChange()
{
	var urlForSend = themeChangeLogicDirModifier+urlForSendMainThemeChange0;
	var dataSend = {formKey};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: dataSend,
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeChangeLogicDirModifier + "error.php?error="+data["error"]+"&page="+urlForSendMainThemeChange0;
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = themeChangeLogicDirModifier + "error.php?error="+data["error"]+"&page="+urlForSendMainThemeChange0;
            }
            else
            {
				verifyFileThemeChange(data);
			}
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
	document.getElementById("runCheck").style.display = "block";
	document.getElementById("runLoad").style.display = "none";
	document.getElementById("verifyLoad").style.display = "block";
	verifyCount = 0;
	verifyCountSuccessThemeChange = 0;
	verifyFileTimerThemeChange = setInterval(function(){verifyFilePollThemeChange(version);},2000);
}

function verifyFilePollThemeChange(version)
{
	if(lockThemeLogic === false)
	{
		lockThemeLogic = true;
		var urlForSend = themeChangeLogicDirModifier + urlForSendMainThemeChange1;
		var data = {version, formKey};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: 'json',
				data,
				type: 'POST',
				success(data)
				{
					if(typeof data === "object"  && "error" in data)
		            {
		                window.location.href = themeChangeLogicDirModifier + "error.php?error="+data["error"]+"&page="+urlForSendMainThemeChange0;
		            }
		            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
		            {
		            	data = JSON.parse(data);
		            	window.location.href = themeChangeLogicDirModifier + "error.php?error="+data["error"]+"&page="+urlForSendMainThemeChange0;
		            }
		            else
		            {
						verifyPostEndThemeChange(data);
					}
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
	document.getElementById("innerDisplayUpdate").innerHTML = "<h1>An error occured while trying to copy over your selected theme. </h1>";
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
	document.getElementById("verifyCheck").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
	redirectToLocationFromUpgradeTheme();
}