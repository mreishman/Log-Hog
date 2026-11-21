function saveAndVerifyGlobalConfigMain(idForForm)
{
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup(dirForAjaxSend, "Saving...");
	data = $(idForm).serializeArray();
	data.push({name: "formKey", value: formKey});
	$.ajax({
        type: "post",
        url: dirForAjaxSend+"core/php/post/globalConfigSaveAjax.php",
        data,
        success(data)
        {
        	handleErrorWithTruthCheck(dirForAjaxSend, data, "globalConfigSaveAjax.php");
		},
        complete()
        {
			verifySaveTimerGlobalConfig(); //verify saved
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
		var urlForSend = dirForAjaxSend+"core/php/post/saveCheckGlobalConfig.php?format=json";
		data["formKey"] = formKey;
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(!handleError(dirForAjaxSend, data, "saveCheckGlobalConfig.php"))
				{
					if(data === true)
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

	saveSuccess();
	fadeOutPopup();
}