var lock = false;
var globalVersionBase = 1;
var verifyCountSuccess = 0;
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
	document.getElementById("runCount").innerHTML = globalVersionBase;
	document.getElementById("verifyCount").innerHTML = globalVersionBase;
	document.getElementById("runLoad").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
	var urlForSendRunScript = urlForSendMain+version+urlForSendMain2;
	var dataSend = {version: version, formKey};
	$.ajax({
		url: getElementById,
		dataType: "json",
		data: dataSend,
		type: "POST",
		success(data)
		{
			let urlMod = "";
			let countNum = urlForSendMain.split("../").length - 1;
			for(let i = 0; i < countNum; i++)
			{
				urlMod += "../";
			}
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = urlMod + "error.php?error="+data["error"];
            }
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = urlMod + "error.php?error="+data["error"];
            }
			verifyFile(data);
		},
		failure(data)
		{
			runScript(startVersion+1);
		}
	});
}


function verifyFile(version)
{
	document.getElementById("runCheck").style.display = "block";
	document.getElementById("runLoad").style.display = "none";
	document.getElementById("verifyLoad").style.display = "block";
	verifyCount = 0;
	verifyCountSuccess = 0;
	verifyFileTimer = setInterval(function(){verifyFilePoll(version);},2000);
}

function verifyFilePoll(version)
{
	if(lock === false)
	{
		lock = true;
		var urlForSend = urlForSendMain0;
		var data = {version: version, formKey};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data: data,
				type: "POST",
				success(data)
				{
					if(typeof data === "object"  && "error" in data)
		            {
		                window.location.href = "../../../error.php?error="+data["error"]+"&page="+urlForSend;
		            }
					else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
		            {
		            	data = JSON.parse(data);
		            	window.location.href = "../../../error.php?error="+data["error"]+"&page="+urlForSend;
		            }
					verifyPostEnd(data, _data);
				},
				failure(data)
				{
					verifyPostEnd(data, _data);
				},
				complete()
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
		verifyCountSuccess++;
		if(verifyCountSuccess >= successVerifyNum)
		{
			verifyCountSuccess = 0;
			clearInterval(verifyFileTimer);
			verifySucceded(data["lastAction"]);
		}
	}
	else
	{
		verifyCountSuccess = 0;
		verifyCount++;
		if(verifyCount > 29)
		{
			clearInterval(verifyFileTimer);
			verifyFail(data["lastAction"]);
		}
	}
}

function updateError()
{
	document.getElementById("innerDisplayUpdate").innerHTML = "<h1>An error occured while trying to upgrade file. </h1>";
}

function verifyFail(action)
{
	updateError();
}

function verifySucceded(action)
{
	retryCount = 0;
	startVersion++;
	globalVersionBase++;
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
	window.location.href = upgradeConfigUrlToRedirectTo;
}