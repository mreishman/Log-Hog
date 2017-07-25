<!DOCTYPE html>
<html>
<head>
	<title>Waiting for update check...</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<script src="../core/js/jquery.js"></script>
</head>
<body>
<?php readfile('../core/html/popup.html') ?>	
<script type="text/javascript">
$( document ).ready(function() {
displayLoadingPopup();
var count = 0; 
var timer = setInterval(function(){ajaxCheck();},3000);
	function ajaxCheck()
		{
			var urlForSend = './updateCheck.php?format=json';
			var data = {status: "updateAction" };
			$.ajax(
			{
				url: urlForSend,
				dataType: 'json',
				data: data,
				type: 'POST',
				success: function(data)
				{
					if(data == "Finished Running Update Script")
					{
						clearInterval(timer);
						window.location.href = 'updater.php';
					}
					else
					{
						if(count > 22)
						{
							clearInterval(timer);
							window.location.href = 'updater.php';
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
</script>
</body>
</html>