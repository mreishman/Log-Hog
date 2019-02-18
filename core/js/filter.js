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
			let filterTextField = getFilterTextField();
			//search field empty, don't filter
			if(filterTextField === "")
			{
				return true;
			}
			//search found in line, show
			if(filterOffOf.indexOf(filterTextField) !== -1)
			{
				if(filterInvert === "true")
				{
					return false;
				}
				return true;
			}
			//search not found, if invert: show
			if(filterInvert === "true")
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
	let filterTextField = getFilterTextField();
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

function getFilterTextField()
{
	let filterTextField = document.getElementsByName("search")[0].value;
	if(caseInsensitiveSearch === "true")
	{
		filterTextField = filterTextField.toLowerCase();
	}
	return filterTextField;
}

function changeFilterCase()
{
	caseInsensitiveSearch = document.getElementById("caseInsensitiveSearch").value;
	possiblyUpdateFromFilter(true);
}

function changeFilterInvert()
{
	filterInvert = document.getElementById("filterInvert").value;
	possiblyUpdateFromFilter(true);
}

function changeHighlightContentMatch()
{
	filterContentHighlight = document.getElementById("filterContentHighlight").value;
	possiblyUpdateFromFilter(true);
}

function changeHighlightContentMatchLine()
{
	filterContentHighlightLine = document.getElementById("filterContentHighlightLine").value;
	possiblyUpdateFromFilter(true);
}

function changeFilterContentMatch()
{
	filterContentLimit = document.getElementById("filterContentLimit").value;
	possiblyUpdateFromFilter(true);
}

function changeFilterContentLinePadding()
{
	filterContentLinePadding = parseInt(document.getElementById("filterContentLinePadding").value);
	possiblyUpdateFromFilter(true);
}

function changeFilterTitleIncludePath()
{
	filterTitleIncludePath = document.getElementById("filterTitleIncludePath").value;
	possiblyUpdateFromFilter(true);
}

function possiblyUpdateFromFilter(force)
{
	if(force || lastContentSearch !== getFilterTextField())
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
		document.getElementById("searchType").value = "content"
	}
	changeSearchplaceholder();
}