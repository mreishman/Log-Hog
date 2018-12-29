$( document ).ready(function() {
displayLoadingPopup();
var count = 0;
var timer = setInterval(function(){ajaxCheck();},3000);
	function ajaxCheck()
		{
			var urlForSend = "./updateCheck.php?format=json";
			var data = {status: "updateAction" };
			$.ajax(
			{
				url: urlForSend,
				dataType: "json",
				data,
				type: "POST",
				success(data)
				{
					if(data == "Finished Running Update Script")
					{
						clearInterval(timer);
						window.location.href = "updater.php";
					}
					else
					{
						if(count > 22)
						{
							clearInterval(timer);
							window.location.href = "updater.php";
						}
						else
						{
							count++;
						}
					}
				},
			});
		}
});