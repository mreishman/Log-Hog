var timeoutVarDevToolsSave;

function saveConfigStatic()
{
	displayLoadingPopup(dirForAjaxSend,"Saving Config Static");
	var data = $("#devConfig").serializeArray();
	data.push({name: "formKey", value: formKey});
	$.ajax({
        type: "post",
        url: dirForAjaxSend + "core/php/post/settingsSaveConfigStatic.php",
        data,
        success(data)
        {
        	handleError(dirForAjaxSend, data, "settingsSaveConfigStatic.php");
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
		$.getJSON(dirForAjaxSend + "core/php/post/configStaticCheck.php", {}, function(data)
		{
            if (!handleError(dirForAjaxSend, data, "configStaticCheck.php") && document.getElementById("versionNumberConfigStaticInput").value === data["version"])
			{
				clearInterval(timeoutVarDevToolsSave);
				saveSuccess();
				location.reload();
			}
		});
	}
	catch(e)
	{
		console.log(e);
	}
}