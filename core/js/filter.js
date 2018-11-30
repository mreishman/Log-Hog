function getFilterData(name, shortName, logData)
{
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
	var filterOffOf = "";
	if(selectedListFilterType === "title")
	{
		if(filterTitleIncludePath === "true")
		{
			filterOffOf = name;
		}
		else
		{
			filterOffOf = shortName;
		}
	}
	else if(selectedListFilterType === "content")
	{
		filterOffOf = logData;
	}

	if(caseInsensitiveSearch === "true")
	{
		if( typeof filterOffOf === "string" && filterOffOf !== "")
		{
			filterOffOf = filterOffOf.toLowerCase();
		}
	}
	return filterOffOf;
}

function showFileFromFilter(id, name, shortName, logData)
{
	var filterOffOf = getFilterData(name, shortName, logData);
	if(logsToHide instanceof Array && (logsToHide.length === 0 || $.inArray(id, logsToHide) === -1 ))
	{
		if(typeof filterOffOf === "string" && filterOffOf !== "")
		{
			var filterTextField = getFilterTextField();
			if(filterTextField === "" || filterOffOf.indexOf(filterTextField) !== -1)
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	return false;
}

function filterContentCheck(textToMatch)
{
	var filterTextField = getFilterTextField();
	if(caseInsensitiveSearch === "true")
	{
		textToMatch = textToMatch.toLowerCase();
	}
	return (textToMatch.indexOf(filterTextField) !== -1);
}

function getFilterTextField()
{
	var filterTextField = document.getElementsByName("search")[0].value;
	if(caseInsensitiveSearch === "true")
	{
		filterTextField = filterTextField.toLowerCase();
	}
	return filterTextField;
}

function changeFilterCase()
{
	caseInsensitiveSearch = document.getElementById("caseInsensitiveSearch").value;
	possiblyUpdateFromFilter();
}

function changeHighlightContentMatch()
{
	filterContentHighlight = document.getElementById("filterContentHighlight").value;
	possiblyUpdateFromFilter();
}

function changeFilterContentMatch()
{
	filterContentLimit = document.getElementById("filterContentLimit").value;
	possiblyUpdateFromFilter();
}

function changeFilterContentLinePadding()
{
	filterContentLinePadding = parseInt(document.getElementById("filterContentLinePadding").value);
	possiblyUpdateFromFilter();
}

function changeFilterTitleIncludePath()
{
	filterTitleIncludePath = document.getElementById("filterTitleIncludePath").value;
	possiblyUpdateFromFilter();
}

function possiblyUpdateFromFilter()
{
	if(lastContentSearch !== getFilterTextField())
	{
		generalUpdate();
		if(oneLogEnable === "true")
		{
			possiblyUpdateOneLogVisibleData();
		}
		lastContentSearch = getFilterTextField();
	}
}

function changeSearchplaceholder()
{
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
	document.getElementById("searchFieldInput").placeholder = "Filter "+selectedListFilterType;
	generalUpdate();
}