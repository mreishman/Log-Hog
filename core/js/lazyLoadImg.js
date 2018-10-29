function loadImgFromData(imgClassName)
{
	var images = document.getElementsByClassName(imgClassName);
	var countOfImg = images.length;
	for(var imgCount = 0; imgCount < countOfImg; imgCount++)
	{
		var currentImg = images[imgCount].src;
		var newImg = images[imgCount].getAttribute("data-src");
		if(currentImg !== newImg)
		{
			images[imgCount].src = newImg;
			var dataAlt = images[imgCount].getAttribute("data-alt");
			if(dataAlt)
			{
				images[imgCount].alt = dataAlt;
			}
			var dataTitle = images[imgCount].getAttribute("data-title");
			if(dataTitle)
			{
				images[imgCount].title = dataTitle;
			}
		}
	}
}

function script(url)
{
    var scriptLoad = document.createElement("script");
    scriptLoad.type = "text/javascript";
    scriptLoad.async = true;
    scriptLoad.src = url;
    scriptLoad.id = url.replace(/[^a-z0-9]/g, "");
    document.getElementsByTagName("head")[0].appendChild(scriptLoad);
}

function css(url)
{
	var fileref = document.createElement("link");
	fileref.rel = "stylesheet";
	fileref.type = "text/css";
	fileref.href = url;
	fileref.id = url.replace(/[^a-z0-9]/g, "");
	document.getElementsByTagName("head")[0].appendChild(fileref);
}