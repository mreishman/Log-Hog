var counter = 0;	
var counterInt = null;

$( document ).ready(function()
{
	counterInt = setInterval(checkIfChange, 3000);

});

function checkIfChange()
{
	var urlForSend = '../core/php/getPercentUpdate.php?format=json'
	var data = {};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data: data,
		type: 'POST',
		success: function(data)
		{
			document.getElementById('innerSettingsText').innerHTML = "<br> Current Percent: "+currentPercent+"% ("+counter+")"+document.getElementById('innerSettingsText').innerHTML;
		  	if(data == currentPercent)
		  	{
		  		counter++
		  		if(counter > 40)
		  		{
		  			window.location.href = '../settings/update.php';
		  		}
		  		else if(currentPercent == 100)
		  		{
		  			finishedUpdate();
		  			clearInterval(counterInt);
		  		}
		  		else
		  		{
		  			updateCounter();
		  		}
		  	}
		  	else
		  	{
		  		counter = 0;
		  		document.getElementById('progressBar').value = data;
		  		currentPercent = data;
		  		if(currentPercent == 100)
		  		{
		  			finishedUpdate();
		  			clearInterval(counterInt);
		  		}
		  		else
		  		{
		  			updateCounter();
		  		}
		  	}
		}
	});	
}

function updateCounter()
{
	var textToUpdateTo = "2 Minutes";
	var counterInner = counter;
	if(counterInner !== 0)
	{
		if(counter <= 20)
		{
			textToUpdateTo = "1 Minute ";
		}
		else
		{
			textToUpdateTo = "";
			counterInner -= 20;
		}
		if(counterInner !== 0)
		{
			textToUpdateTo += ((20-counterInner) * 3) + " Seconds";
		}
	}
	document.getElementById("counterDisplay").innerHTML = textToUpdateTo;
}

function finishedUpdate()
{
	document.getElementById("titleForUpdater").innerHTML = "Finished Update";
	document.getElementById("innerDisplayUpdate").innerHTML = "<a class='link' onclick='window.location.href = \"../settings/update.php\"'  >Back to Log-Hog</a> ";
}