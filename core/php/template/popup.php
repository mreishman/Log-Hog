<div id="popup" class="hidden" style="z-index: 10; position: fixed; display: none;" >
	<div onclick='hidePopup();' id="popupBG" class="bigBlur" style="position: fixed; z-index: 100; left: 0; right: 0; top: 0; bottom: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,.50); " >
	</div>

	<div id="popupContent" class="addBorder addBackground" style="width: 400px; height: 150px; position: fixed; left: 50%; top: 50%; margin-top: -75px; margin-left: -200px; z-index: 120;">
		<div id="popupContentInnerHTMLDiv">
		</div>
	</div>
</div>

<script type="text/javascript">

function hidePopup()
{
	if(document.getElementById('fullScreenMenu') && document.getElementById('fullScreenMenu').style.display === "block")
	{
		document.getElementById('fullScreenMenu').style.zIndex = "25";
	}
	if(document.getElementById('menu'))
	{
		if(!document.getElementById('fullScreenMenu') || document.getElementById('fullScreenMenu').style.display === "none")
		{
			document.getElementById('menu').style.zIndex = "20";
		}
	}
	$('#popup').addClass("hidden");
	setTimeout(function()
	{
		if($("#popup").hasClass("hidden"))
		{
			document.getElementById('popup').style.display = "none";
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
		}
	}, 1000);
}
function showPopup()
{
	if(document.getElementById('menu'))
	{
		document.getElementById('menu').style.zIndex = "4";
	}
	if(document.getElementById('fullScreenMenu') && document.getElementById('fullScreenMenu').style.display !== "none")
	{
		document.getElementById('fullScreenMenu').style.zIndex = "5";
	}
	document.getElementById('popup').style.display = "block";
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
	//reset popup css style vars if needed
	document.getElementById('popupContent').style.width = "400px";
	document.getElementById('popupContent').style.height = "150px";
	document.getElementById('popupContent').style.marginTop = "-75px";
	document.getElementById('popupContent').style.marginLeft = "-200px";
	document.getElementById('popupContent').style.top = "50%";
	document.getElementById('popupContent').style.left = "50%";
	document.getElementById('popupContent').style.backgroundColor = "#444444";
	$('#popup').removeClass("hidden");
}
function displayLoadingPopup(pathToImg = "../")
{
	<?php
	$srcForImage = "core/img/loading.gif";
	if(isset($arrayOfImages))
	{
		$srcForImage = $arrayOfImages["loading"]["src"];
	}
	?>
	var srcForImage = "<?php echo $srcForImage; ?>";
	displayPopup("Loading...","<img src='"+pathToImg+srcForImage+"' height='50' width='50'>","");
}
function displaySavePromptPopup(url)
{
	displayPopup("Changes not Saved!","Are you sure you want to leave the page without saving changes?","<div class='linkSmall' onclick='window.location.href = "+'"'+url+'"'+";' style='margin-left:125px; margin-right:50px;'>Yes</div><div onclick='hidePopup();' class='linkSmall'>No</div>");
}

function displaySavePromptPopupIndex(functionName)
{
	displayPopup("Changes not Saved!","Are you sure you want to leave the page without saving changes?","<div class='linkSmall' onclick='hidePopup();"+functionName+";' style='margin-left:125px; margin-right:50px;'>Yes</div><div onclick='hidePopup();' class='linkSmall'>No</div>");
}

function displayPopup(header, content, buttons)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' ><span id='popupHeaderText' >"+header+"</span></div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px; height: 70px; overflow: auto; margin-top: 5px; margin-bottom: 5px;'>"+content+"</div>"+buttons;
}
</script>