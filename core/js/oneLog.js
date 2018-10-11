function addOneLogTab()
{
	var menu = $("#menu");
	var blank = $("#storage .menuItem").html();
	var nameForLog = "New";
	classInsert = "";
	var item = blank;
	item = item.replace(/{{title}}/g, nameForLog);
	item = item.replace(/{{id}}/g, "oneLogTab");
	if(groupByColorEnabled === "true")
	{
		classInsert += " buttonColor1 ";
	}
	classInsert += " IgnoreAllGroupLogicGroup ";
	classInsert += " allGroup ";
	item = item.replace(/{{class}}/g, classInsert);
	var itemAdded = false;
	if(!itemAdded)
	{
		menu.append(item);
	}
}

function toggleVisibleOneLog()
{
	if(document.getElementById("oneLogVisible").value === "false")
	{
		document.getElementById("oneLogTab").style.display = "none";
	}
	else
	{
		document.getElementById("oneLogTab").style.display = "inline-block";
	}
}