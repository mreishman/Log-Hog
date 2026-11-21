function generateTimestampExample()
{
	if(typeof exampleLineForTimestampStyle === "undefined") {
		return;
	}
	let line = exampleLineForTimestampStyle;
	let arrayOfText = dateTimeSplit(line);
	let timeFormat = dateTimeFormat(arrayOfText, false); 
	if ($("#settingsLogFormatVarsDateTime select[name=dateTextBold]").val() === "true")
	{
		timeFormat = "<b>" + timeFormat + "</b>";
	}
	let timePadding = "<td style=\"width: "+$("#settingsLogFormatVarsDateTime select[name=dateTimePadding]").val()+"px;\" ></td>";

	if($("#settingsLogFormatVarsDateTime select[name=dateTextFormatColumn]").val() !== "false")
	{
		line = "<td style=\"padding: 0; font-family: " +
		$("#logStyle select[name=fontFamily]").val() + 
		"; color: "+
		$("#logStyle input[name=logFontColor]").val() +
		"; font-size: " +
		$("#logStyle select[name=logFontSize]").val() +
		"%; \" >" + timeFormat + "</td>" + timePadding + "<td style=\"padding: 0; font-family: " +
		$("#logStyle select[name=fontFamily]").val() + 
		"; color: "+
		$("#logStyle input[name=logFontColor]").val() +
		"; font-size: " +
		$("#logStyle select[name=logFontSize]").val() +
		"%; \" >" + arrayOfText[1]
	}
	else
	{
		line = "<td style=\"padding: 0; font-family: " +
		$("#logStyle select[name=fontFamily]").val() + 
		"; color: "+
		$("#logStyle input[name=logFontColor]").val() +
		"; font-size: " +
		$("#logStyle select[name=logFontSize]").val() +
		"%; \" >" + timeFormat + arrayOfText[1]
	}

	let html = "<table><tr style=\"border-spacing: 0; \">" + line + "</td></tr></table>";
	$("#exampleStyleTimestampSpan").html(html);
	$("#exampleStyleTimestampSpan").css("background-color", $("#logStyle input[name=backgroundColor]").val());
}

function timestampStyleListeners()
{
	generateTimestampExample();
	$("#settingsLogFormatVarsDateTime input, #settingsLogFormatVarsDateTime select").on("change", function() {
		generateTimestampExample();
	})
}

function showOrHideLogTimestamp()
{
	if($("#dateTextFormatEnable").val() === "true")
	{
		$("#settingsMainLogDateTimeFormatMenu").show();
	}
	else
	{
		$("#settingsMainLogDateTimeFormatMenu").hide();
	}
}

function showOrHidelogLinkedFileSettings()
{
	if($("#logFormatFileEnable").val() === "true")
	{
		$("#settingsLinkedLogLogFormatMenu").show();
	}
	else
	{
		$("#settingsLinkedLogLogFormatMenu").hide();
	}
}

$( document ).ready(function() {
    timestampStyleListeners();
});
