var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmlDevAdvanced2;
var devAdvanced2Data;
var savedInnerHtmlDevAdvanced3;
var devAdvanced3Data;
var titleOfPage = "Dev";
var timeoutVar;

function checkForChange()
{
	if(	checkForChangesArray(["devBranch","devAdvanced2","devAdvanced3"]))
	{
		return true;
	}
	return false;
}

function saveConfigStatic()
{
	displayLoadingPopup();
	var data = $("#devAdvanced2").serializeArray();
	$.ajax({
        type: "post",
        url: "../core/php/settingsSaveConfigStatic.php",
        data,
        complete()
        {
          //verify saved
          timeoutVar = setInterval(function(){newVersionNumberCheck();},3000);
        }
      });
}

function newVersionNumberCheck()
{
	try
	{
		$.getJSON("../core/php/configStaticCheck.php", {}, function(data) 
		{
			var dataExt = document.getElementById("versionNumberConfigStaticInput").value;
			console.log(dataExt + " === " + data['version']);
			console.log(dataExt === data['version']);
			if(dataExt === data['version'])
			{
				clearInterval(timeoutVar);
				saveSuccess();
				location.reload();
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["devBranch","devAdvanced2","devAdvanced3"]);
	setInterval(poll, 100);
});