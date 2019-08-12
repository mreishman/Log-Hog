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
					if(typeof data === "object"  && "error" in data)
		            {
		                window.location.href = "./error.php?error="+data["error"];
		            }
		            else if(typeof data === "string" && data.indexOf("error:") > -1)
		            {
		            	data = JSON.parse(data);
		            	window.location.href = "./error.php?error="+data["error"];
		            }
					else if(data == "Finished Running Update Script")
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