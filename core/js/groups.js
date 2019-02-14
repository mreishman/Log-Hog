function addToGroupTab(newGroups)
{
	newGroups = newGroups.split(" ");
	var newGroupsLength = newGroups.length;
	for(var NGcount = 0; NGcount < newGroupsLength; NGcount++)
	{
		if(!($("#selectForGroup option[value='"+newGroups[NGcount]+"']").length > 0) && newGroups[NGcount] !== "")
		{
			$("#selectForGroup").append("<option value='"+newGroups[NGcount]+"'>"+newGroups[NGcount]+"</option>");
		}
	}
}

function getArrayOfGroups(data)
{
	var fileDataKeys = Object.keys(data);
	var fileDataKeysLength = fileDataKeys.length;
	var arrayOfGroups = new Array();
	for(var OGRcount = 0; OGRcount < fileDataKeysLength; OGRcount++)
	{
		var group = data[fileDataKeys[OGRcount]]["Group"];
		group = group.split(" ");
		var groupsLength = group.length;
		for(var CGcount = 0; CGcount < groupsLength; CGcount++)
		{
			if($.inArray(group[CGcount], arrayOfGroups) === -1 && $.inArray(fileDataKeys[OGRcount].replace(/[^a-z0-9]/g, ""), logsToHide) === -1)
			{
				arrayOfGroups.push(group[CGcount]);
			}
		}
	}
	return arrayOfGroups;
}

function updateGroupsOnTabs(data, arrayOfGroupsModded)
{
	var arrayOfGroupsLength = arrayOfGroupsModded.length;
	var fileDataKeysTwo = Object.keys(data);
	var fileDataKeysLengthTwo = fileDataKeysTwo.length;
	var idForTab = "";
	for(var EGRcount = 0; EGRcount < arrayOfGroupsLength; EGRcount++)
	{
		arrayOfGroupsModded[EGRcount] = arrayOfGroupsModded[EGRcount] + "Group";
	}
	for(var UGRcount = 0; UGRcount < fileDataKeysLengthTwo; UGRcount++)
	{
		idForTab = fileDataKeysTwo[UGRcount].replace(/[^a-z0-9]/g, "");
		if(document.getElementById(idForTab))
		{
			var classList = document.getElementById(idForTab).className.split(" ");
			var classListLength = classList.length;
			for(var classCount = 0; classCount < classListLength; classCount++)
			{
				if(classList[classCount].indexOf("Group") > -1 && classList[classCount] !== "allGroup")
				{
					if($.inArray(classList[classCount], arrayOfGroupsModded) === -1)
					{
						//class is not in group, remove it from tab
						$("#"+idForTab).removeClass(classList[classCount]);
						if($("#"+idForTab+"GroupInName"))
						{
							//group name shows, update if there is one
							var possibleNewGroup = data[fileDataKeysTwo[UGRcount]]["Group"];
							possibleNewGroup = possibleNewGroup.split(" ")[0];
							$("#"+idForTab+"GroupInName").html("");
							if(possibleNewGroup !== "")
							{
								$("#"+idForTab+"GroupInName").html(possibleNewGroup+":");
							}
						}
					}
				}
			}
		}
	}

	for(var AGRcount = 0; AGRcount < fileDataKeysLengthTwo; AGRcount++)
	{
		idForTab = fileDataKeysTwo[AGRcount].replace(/[^a-z0-9]/g, "");
		if(document.getElementById(idForTab))
		{
			var groupSearch = data[fileDataKeysTwo[AGRcount]]["Group"];
			groupSearch = groupSearch.split(" ");
			var groupSearchLength = groupSearch.length;
			for(var GScount = 0; GScount < groupSearchLength; GScount++)
			{
				if(!$("#"+idForTab).hasClass(groupSearch[GScount]+"Group"))
				{
					$("#"+idForTab).addClass(groupSearch[GScount]+"Group");
				}
			}
		}
	}
}

function removeOldGroups(data, arrayOfGroups)
{
	var modCOScount = 0;
	var currentOptionsSelect = document.getElementById("selectForGroup").options;
	var currentOptionsSelectLength = currentOptionsSelect.length;
	for(var COScount = 0; COScount < currentOptionsSelectLength; COScount++)
	{
		if(currentOptionsSelect[modCOScount].value !== "all" && $.inArray(currentOptionsSelect[modCOScount].value, arrayOfGroups) === -1)
		{
			//remove because not in new array
			var selectGroupSelector = document.getElementById("selectForGroup");
			$("#selectForGroup option[value=\""+currentOptionsSelect[modCOScount].value+"\"]").remove();
			modCOScount--;
		}
		modCOScount++;
	}
}

function showFileFromGroup(id)
{
	let groupSelect = $("#selectForGroup").val();
	if(!groupSelect)
	{
		document.getElementById("selectForGroup").value = "all"
		return true;
	}
	let groupSelectLength = groupSelect.length;
	if(groupSelect[0] === "all")
	{
		if(groupSelectLength !== 1)
		{
			document.getElementById("selectForGroup").value = "all"
		}
		return true;
	}
	for(let i = 0; i < groupSelectLength; i++)
	{
		if($("#"+id).hasClass(groupSelect[i]+"Group"))
		{
			return true;
		}
	}
}

function toggleGroupedGroups()
{
	var groupSelect = document.getElementById("selectForGroup").value;
	var listOfTabs = $("#menu a");
	var listOfTabsKeys = Object.keys(listOfTabs);
	var listOfTabsKeysLength = listOfTabsKeys.length;
	for(var groupCount = 0; groupCount < listOfTabsKeysLength; groupCount++)
	{
		var objectTab = listOfTabs[listOfTabsKeys[groupCount]];
		if(!objectTab)
		{
			continue;
		}
		var idOfObject = objectTab.id;
		if($("#"+idOfObject).hasClass("active"))
		{
			//show tab if hidden
			$("#"+idOfObject).show();
		}
		else if($.inArray(idOfObject, logsToHide) > -1)
		{
			//hide tab if not valid
			$("#"+idOfObject).hide();
		}
		else if(document.getElementById("searchFieldInput").value === "")
		{
			if(showFileFromGroup(idOfObject))
			{
				//show tab if valid
				$("#"+idOfObject).show();
			}
			else
			{
				//hide tab if not valid
				$("#"+idOfObject).hide();
			}
		}
	}
	if(oneLogEnable === "true")
	{
		toggleVisibleOneLog();
	}
	//hide empty files if needed
	hideEmptyLogs();
	resize();
}