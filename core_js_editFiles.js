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
	var data = {file: "../../"+filepath};
	$.ajax(
	{
		url: urlForSend,
		data,
		name,
		type: "POST",
		success(data)
		{
			showFile(data, this.name)
		},
		error(data, data2)
		{
			console.log(data);
			console.log(data2);
		},
		complete()
		{
			console.log("Fin");
		}
	});
}

function showFile(data, name)
{
	$(".documentLink").removeClass("active");
	$("#"+name+"Link").addClass("active");
	document.getElementById("document").innerHTML = data;
}