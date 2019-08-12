$(document).ready(function()
{
	showFile(newValue, "LocalConfig");

	var targetHeight = window.innerHeight - $("#fixed").outerHeight() - 10;
	$("#scrollable").outerHeight(targetHeight);

	var targetWidth = window.innerWidth - $("#leftCol").outerWidth() - 30;
	$("#rightCol").outerWidth(targetWidth);
	$("#document").outerWidth(targetWidth);
});

function loadFile(filepath, name)
{
	var urlForSend = "../core/php/returnFileContents.php?format=json";
	var data = {file: "../../"+filepath, formKey};
	$.ajax(
	{
		url: urlForSend,
		data,
		name,
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "../error.php?error="+data["error"]+"&page=returnFileContents.php";
            }
            else if(typeof data === "string" && data.indexOf("error:") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = "../error.php?error="+data["error"]+"&page=returnFileContents.php";
            }
            else
            {
				showFile(data, this.name);
			}
		},
		error(data, data2){},
		complete(){}
	});
}

function showFile(data, name)
{
	$(".documentLink").removeClass("active");
	$("#"+name+"Link").addClass("active");
	document.getElementById("document").innerHTML = data;
}