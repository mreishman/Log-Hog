var flasher = null;

function flashTitle() //needed for file check
{
	if (flasher !== null)
	{
		return;
	}
	try
	{
		$("title").text("");
		flasher = setInterval(function() {
			$("title").text($("title").text() === "" ? title : "");
		}, 1000);
	}
	catch(e)
	{
		console.log(e);
	}
}

function stopFlashTitle()
{
	try
	{
		clearInterval(flasher);
		flasher = null;
		$("title").text("Log Hog | "+title);
	}
	catch(e)
	{
		console.log(e);
	}

}