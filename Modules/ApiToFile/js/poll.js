var apitofile_pollTimer = null;

function apitofile_startPollTimer()
{
	/* Dont try catch visibility  */
	let apiToFile_pollRateCalc = apiToFilePollRate;
	if(apiToFilePollRateType === "Seconds")
	{
		apiToFile_pollRateCalc *= 1000;
	}
	if(apiToFilePauseOnNotFocus === "true")
	{
		apitofile_pollTimer = setInterval(apitofile_checkIfPageHidden, apiToFile_pollRateCalc);
	}
	else
	{
		let apiToFile_bgPollRateCalc = apiToFilePollBackgroundType;
		if(apiToFilePollBackgroundType === "Seconds")
		{
			apiToFile_bgPollRateCalc *= 1000;
		}
		apitofile_pollTimer = Visibility.every(apiToFile_pollRateCalc, apiToFile_bgPollRateCalc, function () { apitofile_checkIfPageHidden(); });
	}
}

function apitofile_clearPollTimer()
{
	/* Dont try catch visibility  */

	if(apiToFilePauseOnNotFocus === "true")
	{
		clearInterval(apitofile_pollTimer);
	}
	else
	{
		Visibility.stop(apitofile_pollTimer);
	}
	apitofile_pollTimer = null;
}

function apitofile_checkIfPageHidden()
{
	try
	{
		if(isPageHidden() && apiToFilePauseOnNotFocus === "true" || userPaused)
		{
			//hidden
			apitofile_pausePollFunction();
			return;
		}

		//not hidden
		if(apitofile_pollTimer === null)
		{
			apitofile_poll();
			apitofile_startPollTimer();
		}
		return;
	}
	catch(e)
	{
		console.log(e);
	}
}

function apitofile_pausePollFunction()
{
	try
	{
		if(apitofile_pollTimer !== null)
		{
			apitofile_clearPollTimer();
		}
	}
	catch(e)
	{
		console.log(e);
	}
}

function apitofile_poll()
{
	var data = {
		formKey
	};
	$.ajax({
			url: "core/php/post/getFileFromApi.php?format=json",
			dataType: "json",
			data,
			type: "POST",
	success(data)
	{
		if (!handleError("", data, "getFileFromApi.php"))
		{
			console.log(data);
		}
	},
	});
}
 	

// A $( document ).ready() block.
$( document ).ready(function() {
    apitofile_poll();
	apitofile_startPollTimer();
});