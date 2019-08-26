var currentFile = 1;
var lock = false;
var urlForSendMain = "../../../core/php/performSettingsInstallUpdateAction.php?format=json";

$( document ).ready(function()
{
	remove();
});

function remove()
{
	if(arrayOfFilesToDelete[currentFile-1]["type"] === "file")
	{
		removeMain({
			action: "removeZipFile",
			fileToUnlink: "../../"+arrayOfFilesToDelete[currentFile-1]["fullPath"]
		});
	}
	else
	{
		removeMain({
			action: "removeUnZippedFiles",
			locationOfFilesThatNeedToBeRemovedRecursivally: "../../"+arrayOfFilesToDelete[currentFile-1]["fullPath"]
		});
	}
}

function updateCount()
{
	document.getElementById("runCount").innerHTML = currentFile;
	document.getElementById("verifyCount").innerHTML = currentFile;
	document.getElementById("runLoad").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
}

function removeMain(dataSend)
{
	dataSend["formKey"] = formKey;
	updateCount();
	$.ajax({
		url: urlForSendMain,
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
			verifyRemoveFile(data);
		}
	});
}

function verifyRemoveFile()
{
	document.getElementById("runCheck").style.display = "block";
	document.getElementById("runLoad").style.display = "none";
	document.getElementById("verifyLoad").style.display = "block";
	verifyCount = 0;
	verifyCountSuccess = 0;
	verifyFileTimer = setInterval(function(){verifyFilePoll(arrayOfFilesToDelete[currentFile-1]["fullPath"]);},2000);
}

function verifyFilePoll(file)
{
	if(lock === false)
	{
		lock = true;
		var data = {action: "verifyFileIsThere",fileLocation: file, "isThere" : false, formKey};
		(function(_data){
			$.ajax({
				url: urlForSendMain,
				dataType: "json",
				data,
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
			verifySucceded();
		}
	}
	else
	{
		verifyCountSuccess = 0;
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
	document.getElementById("innerDisplayUpdate").innerHTML = "<h1>An error occured while trying to upgrade file. </h1>";
}

function verifyFail()
{
	updateError();
}

function verifySucceded()
{
	retryCount = 0;
	currentFile++;
	if(currentFile <= totalCountOfFilesToDelete)
	{
		remove();
	}
	else
	{
		finishedTmpUpdate();
	}
}

function finishedTmpUpdate()
{
	document.getElementById("verifyCheck").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
	redirectToLocationFromUpgradeTheme();
}