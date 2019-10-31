function saveAndVerifyGlobalConfigMain(idForForm)
{
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup(dirForAjaxSend, "Saving...");
	data = $(idForm).serializeArray();
	data.push({name: "formKey", value: formKey});
	$.ajax({
        type: "post",
        url: dirForAjaxSend+"core/php/globalConfigSaveAjax.php",
        data,
        success(data)
        {
        	if(typeof data === "object"  && "error" in data)
            {
                window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=globalConfigSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=globalConfigSaveAjax.php";
            }
			else if(data !== "true")
			{
				window.location.href = dirForAjaxSend+"error.php?error="+data+"&page=core/php/globalConfigSaveAjax.php";
			}
		},
        complete()
        {
          //verify saved
          verifySaveTimerGlobalConfig();
        }
      });
}

function verifySaveTimerGlobalConfig()
{
	countForVerifySave = 0;
	pollCheckForUpdate = setInterval(timerVerifySaveGlobalConfig,3000);
}

function timerVerifySaveGlobalConfig()
{
	displayLoadingPopup(dirForAjaxSend, "Verifying Save...");
	countForVerifySave++;
	if(countForVerifySave < 20)
	{
		var urlForSend = dirForAjaxSend+"core/php/saveCheckGlobalConfig.php?format=json";
		data["formKey"] = formKey;
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
					window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=saveCheckGlobalConfig.php";
				}
				else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=saveCheckGlobalConfig.php";
	            }
				else if(data === true)
				{
					countForVerifySaveSuccess++;
					if(countForVerifySaveSuccess >= successVerifyNum)
					{
						clearInterval(pollCheckForUpdate);
						countForVerifySaveSuccess = 0;
						saveVerifiedGlobalConfig();
					}
				}
				else
				{
					countForVerifySaveSuccess = 0;
				}
			},
		});
	}
	else
	{
		clearInterval(pollCheckForUpdate);
		saveError();
	}
}

function saveVerifiedGlobalConfig()
{

	refreshArrayObject(idForFormMain);

	if($("[name='branchSelected']"))
	{
		if($("[name='enableDevBranchDownload']")[0].value === "true")
		{
			if($("[name='branchSelected']")[0].options.length === 2)
			{
				//append
				$("[name='branchSelected']").append("<option value='dev'>Dev</option>")
			}
		}
		else
		{
			if($("[name='branchSelected']")[0].options.length === 3)
			{
				//remove
				$("[name='branchSelected'] option[value='dev']").remove();
			}
		}
	}

	saveSuccess();
	fadeOutPopup();

}