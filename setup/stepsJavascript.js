var pollCheckForUpdate;

function updateStatus(status)
{
	var urlForSend = './updateSetupStatus.php?format=json'
	var data = {status: status };
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data)
	{
		pollCheckForUpdate = setInterval(function(){verifyStatusChange(status);},3000);
  	}
		});
	return false;
}

function verifyStatusChange(status)
{
	var urlForSend = './updateSetupCheck.php?format=json'
	var data = {status: status };
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data)
	{
		clearInterval(pollCheckForUpdate);
		if(data == true)
		{
			if(status == "finished")
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