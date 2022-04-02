function handleError(urlModifier, data, file)
{
	if(typeof data === "object"  && "error" in data)
    {
        window.location.href = urlModifier + "error.php?error="+data["error"]+"&page=" + file;
        return true;
    }
    if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
    {
        try
        {
            data = JSON.parse(data);
            window.location.href = urlModifier + "error.php?error="+data["error"]+"&page=" + file;
            return true;
        }
        catch (error)
        {
            console.log(error);
        }
    }
    return false;
}

function handleErrorWithTruthCheck(urlModifier, data, file)
{
    if(handleError(urlModifier, data, file))
    {
        return true;
    }
    if(data !== "true")
    {
        window.location.href = urlModifier + "error.php?error="+data+"&page=" + file;
        return true;
    }
    return false;
}