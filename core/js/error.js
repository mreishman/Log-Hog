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
        url: "core/php/post/settingsSaveAjax.php",
        data,
        success(data)
        {
            handleErrorWithTruthCheck("../", data, "settingsSaveAjax.php");
        }
    });
}
