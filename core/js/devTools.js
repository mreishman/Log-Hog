var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmldevConfig;
var devConfigData;
var titleOfPage = "Dev";
var timeoutVar;

function checkIfChanges()
{
	if(	checkForChangesArray(["devBranch","devConfig"]))
	{
		return true;
	}
	return false;
}

function saveConfigStatic()
{
	displayLoadingPopup("../","Saving Confit Static");
	var data = $("#devConfig").serializeArray();
	$.ajax({
        type: "post",
        url: "../core/php/settingsSaveConfigStatic.php",
        data,
        success(data)
        {
        	if(typeof data === "object"  && "error" in data && data["error"] === 14)
            {
                window.location.href = "../error.php?error=14&page=settingsSaveConfigStatic.php";
            }
        },
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
		displayLoadingPopup("../","Verifying Version");
		$.getJSON("../core/php/configStaticCheck.php", {}, function(data)
		{
			var dataExt = document.getElementById("versionNumberConfigStaticInput").value;
			if(typeof data === "object"  && "error" in data && data["error"] === 14)
			{
				window.location.href = "../error.php?error=14&page=configStaticCheck.php";
			}
			else if(dataExt === data["version"])
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
	refreshArrayObjectOfArrays(["devBranch","devConfig"]);

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(["devBranch","devConfig"]);
		},
		true
	);

	setInterval(poll, 100);
});