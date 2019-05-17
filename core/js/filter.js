function getFilterData(id, name, shortName, logData)
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

		if(filterTitleIncludeGroup === "true")
		{
			filterOffOf += fileData[name]["Group"];
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
	let filterOffOf = getFilterData(id, name, shortName, logData);
	if(logsToHide instanceof Array && (logsToHide.length === 0 || $.inArray(id, logsToHide) === -1 ))
	{
		if(typeof filterOffOf === "string" && filterOffOf !== "")
		{
			let filterTextField = getFilterTextField(getPositionOfLogInLogDisplay(id)) || getFilterTextField();
			//search found in line || inverted || empty : show
			if(filterTextField === "" || filterInvert === "true" || filterOffOf.indexOf(filterTextField) !== -1)
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

function filterContentCheck(textToMatch, filterTextField)
{
	if(filterTextField === "")
	{
		return true;
	}
	if(caseInsensitiveSearch === "true")
	{
		textToMatch = textToMatch.toLowerCase();
	}
	textToMatch = unescapeHTML(textToMatch);
	let filterResult = (textToMatch.indexOf(unescapeHTML(filterTextField)) !== -1);
	if(filterInvert === "true")
	{
		filterResult = !filterResult;
	}
	return filterResult;
}

function getFilterTextField(windowNum = 'false')
{
	let filterTextField = document.getElementById("searchFieldInput").value;
	if(document.getElementById("searchFieldInput-"+windowNum) && document.getElementById("searchFieldInput-"+windowNum).value !== "")
	{
		filterTextField = document.getElementById("searchFieldInput-"+windowNum).value;
	}
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

function changeFilterInvert()
{
	filterInvert = document.getElementById("filterInvert").value;
	possiblyUpdateFromFilter();
}

function changeHighlightContentMatch()
{
	filterContentHighlight = document.getElementById("filterContentHighlight").value;
	possiblyUpdateFromFilter();
}

function changeHighlightContentMatchLine()
{
	filterContentHighlightLine = document.getElementById("filterContentHighlightLine").value;
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
	generalUpdate();
	if(oneLogEnable === "true")
	{
		possiblyUpdateOneLogVisibleData();
	}
}

function changeSearchplaceholder()
{
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
	document.getElementById("searchFieldInput").placeholder = "Filter "+selectedListFilterType;
	generalUpdate();
}

function toggleFilterType()
{
	if(document.getElementById("searchType").value === "content")
	{
		//switch to title
		document.getElementById("searchType").value = "title";
	}
	else
	{
		//switch to content
		document.getElementById("searchType").value = "content";
	}
	changeSearchplaceholder();
}

function showLogWindowFilter(windowNum)
{
	displayLoadingPopup("");
	let currentDisplay = document.getElementById("searchFieldInputOuter-"+windowNum).style.display;
	if(currentDisplay !== "block")
	{
		document.getElementById("searchFieldInputOuter-"+windowNum).style.display = "block";
	}
	else
	{
		document.getElementById("searchFieldInputOuter-"+windowNum).style.display = "none";
	}
	setTimeout(function() {
			resize();
			hidePopup();
		}, 2);

}