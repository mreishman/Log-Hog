var offsetHeight = 0;
if(document.getElementById('menu'))
{
	offsetHeight += document.getElementById('menu').offsetHeight;
}
if(document.getElementById('menu2'))
{
	offsetHeight += document.getElementById('menu2').offsetHeight;
}
var heightOfMain = window.innerHeight - offsetHeight;
var heightOfMainStyle = 'height:';
heightOfMainStyle += heightOfMain;
heightOfMainStyle += 'px';
document.getElementById("main").setAttribute("style",heightOfMainStyle);
var idForm = "";
var countForVerifySave = 0;

function saveAndVerifyMain(idForForm)
{
	idForm = idForForm;
	displayLoadingPopup();
	$.ajax({
            type: 'post',
            url: '../core/php/settingsSaveAjax.php',
            data: $(idForm).serialize(),
            complete: function () {
              //verify saved
              saveVerified();
            }
          });

}

function verifySaveTimer()
{
	countForVerifySave = 0;

}

function timerVerifySave()
{

}

function saveVerified()
{
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Saved Changes!</div><br><br><div style='width:100%;text-align:center;'> <img src='../core/img/greenCheck.png' height='50' width='50'> </div>";
	fadeOutPopup();
}

function saveError()
{
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Error</div><br><br><div style='width:100%;text-align:center;'> An Error Occured While Saving... </div>";
	fadeOutPopup();
}

function fadeOutPopup()
{
	setTimeout(function()
	{ 
		hidePopup(); 
	}, 1000);
}