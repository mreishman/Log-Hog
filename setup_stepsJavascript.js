var pollCheckForUpdate;
var countChecker = 0;
var statusExt = "";
var baseUrl = "../";
var successVerifyNum = 2;

function updateStatus(status)
{
	statusExt = status;
	displayLoadingPopup();
	var urlForSend = "./updateSetupStatus.php?format=json";
	var data = {status, formKey};
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "./error.php?error="+data["error"];
            }
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = "./error.php?error="+data["error"];
            }
            else
            {
				pollCheckForUpdate = setInterval(function(){verifyStatusChange(status);},3000);
			}
		}
	});
	return false;
}

function verifyStatusChange(status)
{
	countChecker++;
	if(countChecker < 20)
	{
		var urlForSend = "./updateSetupCheck.php?format=json";
		var data = {status, formKey};
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(typeof data === "object"  && "error" in data)
	            {
	                window.location.href = "./error.php?error="+data["error"];
	            }
				else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = "./error.php?error="+data["error"];
	            }
				else if(data === status)
				{
					clearInterval(pollCheckForUpdate);
					if(status === "finished")
					{
						defaultSettings();
					}
					else
					{
						customSettings();
					}
				}
			},
		});
	}
	else
	{
		clearInterval(pollCheckForUpdate);
		showPopup();
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >An error occured?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to save settings. Try again?</div><div class='link' onclick='window.location.href = \"../\";' style='margin-left:125px; margin-right:50px;margin-top:25px;'>No</div><div onclick='noClickedReset();' class='link'>Yes</div></div>";
	}
}

function noClickedReset()
{
	countChecker = 0;
	hidePopup();
}