var timeoutVarDevToolsSave;

function saveConfigStatic()
{
	displayLoadingPopup(dirForAjaxSend,"Saving Confit Static");
	var data = $("#devConfig").serializeArray();
	data.push({name: "formKey", value: formKey});
	$.ajax({
        type: "post",
        url: dirForAjaxSend + "core/php/settingsSaveConfigStatic.php",
        data,
        success(data)
        {
        	if(typeof data === "object"  && "error" in data)
            {
                window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveConfigStatic.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveConfigStatic.php";
            }
        },
        complete()
        {
          //verify saved
          timeoutVarDevToolsSave = setInterval(function(){newVersionNumberCheck();},3000);
        }
      });
}

function newVersionNumberCheck()
{
	try
	{
		displayLoadingPopup(dirForAjaxSend,"Verifying Version");
		$.getJSON(dirForAjaxSend + "core/php/configStaticCheck.php", {}, function(data)
		{
			var dataExt = document.getElementById("versionNumberConfigStaticInput").value;
			if(typeof data === "object"  && "error" in data)
			{
				window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=configStaticCheck.php";
			}
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=configStaticCheck.php";
            }
			else if(dataExt === data["version"])
			{
				clearInterval(timeoutVarDevToolsSave);
				saveSuccess();
				location.reload();
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}