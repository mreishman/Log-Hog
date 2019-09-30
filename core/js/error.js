var verifyCountSuccess = 0;
var installUpdatePoll = null;
var totalCounterInstall = 0;

function showPopup()
{
    document.getElementById('popup').style.display = "block";
    document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
}
function hidePopup()
{
    document.getElementById('popup').style.display = "none";
    document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
}
function toggleReset()
{
    if(document.getElementById('popup').style.display === "none")
    {
        resetSettingsPopup();
    }
    else
    {
        hidePopup();
    }
}

function saveAndVerifyMain(idForForm)
{
    idForm = "#"+idForForm;
    data = $(idForm).serializeArray();
    data.push({name: "formKey", value: formKey});
    $.ajax({
        type: "post",
        url: "core/php/settingsSaveAjax.php",
        data,
        success(data)
        {
            if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
                data = JSON.parse(data);
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(data !== "true")
            {
                window.location.href = "../error.php?error="+data+"&page=core/php/settingsSaveAjax.php";
            }
        }
    });
}

function resetUpdateSettings()
{
    document.getElementById("popup").style.display = "block";
    document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Resetting...</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'> Resetting Update Settings... Please wait... </div>";
    var urlForSend = "core/php/resetUpdateFilesToDefault.php?format=json";
    var data = {status: "" , formKey};
    $.ajax(
    {
        url: urlForSend,
        dataType: "json",
        data,
        type: "POST",
        complete(data)
        {
            if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
                data = JSON.parse(data);
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else
            {
                verifyCountSuccess = 0;
                installUpdatePoll = setInterval(function(){verifyChange();},3000);
            }
        }
    });
}

function verifyChange()
{
    var urlForSend = "update/updateActionCheck.php?format=json";
    var data = {status: "" , formKey};
    $.ajax(
    {
        url: urlForSend,
        dataType: "json",
        data,
        type: "POST",
        success(data)
        {
            if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
                data = JSON.parse(data);
                window.location.href = "../error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(data == "finishedUpdate")
            {
                verifyCountSuccess++;
                if(verifyCountSuccess >= 4)
                {
                    verifyCountSuccess = 0;
                    clearInterval(installUpdatePoll);
                    //success popup
                    document.getElementById("popup").style.display = "block";
                    document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Success</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'> Update settings successfully reset! </div>";
                }
            }
            else
            {
                verifyCountSuccess = 0;
            }
        },
        failure(data)
        {
            if(totalCounterInstall > 30)
            {
                //error message
                clearInterval(installUpdatePoll);
                document.getElementById("popup").style.display = "block";
                document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An Error occured when trying to reset update progress</div>";
            }
        },
        complete(data)
        {
            totalCounterInstall++;
        }
    });
}