<?php
if(!isset($settings))
{
	require_once(baseURL()."core/php/class/settings.php");
	$settings = new settings();
}
function makeTrueFalseSelect($selectValue)
{
	return $settings->createSelect(
		array(
			0		=> array(
				"value" =>	"true",
				"name"	=>	"True"
			)
		),
		(String)$selectValue,
		array(
			"value" => 	"false",
			"name"	=>	"False"
		)
	);
}

function generateFileTypeSelect($selectValue)
{
	return $settings->createSelect(
		array(
			0		=> array(
				"value" =>	"file",
				"name"	=>	"File"
			),
			1		=> array(
				"value" =>	"folder",
				"name"	=>	"Folder"
			)
		),
		(String)$selectValue,
		array(
			"value" => 	"other",
			"name"	=>	"Other"
		)
	);
}

function makePatternSelect($selectValue, $selectOptions)
{
	return $settings->createSelect(
		$selectOptions,
		(String)$selectValue,
		array(
			"value" => 	"other",
			"name"	=>	"Other"
		)
	);
}


function generateSaveBlock($data = array(), $arrayOfImages)
{
	if(!isset($core))
	{
		$core = new core();
	}
	$rowNumber = "{{rowNumber}}";
	$fileNumber = "{{fileNumber}}";
	$filePermsDisplay = "{{filePermsDisplay}}";
	$fileImage = "{{fileImage}}";
	$location = "{{location}}";
	$pattern = "{{pattern}}";
	$key = "{{key}}";
	$recursiveOptions = "{{recursiveOptions}}";
	$excludeTrimOptions = "{{excludeTrimOptions}}";
	$typeFolder = " {{typeFolder}} ";
	$typeFile = " {{typeFile}} ";
	$FileType = "{{FileTypeOptions}}";
	$filesInFolder = "{{filesInFolder}}";
	$AutoDeleteFiles = "{{AutoDeleteFiles}}";
	$Group = "{{Group}}";
	$FileInformation = "{{FileInformation}}";
	$Name = "{{Name}}";
	$AlertEnabled = "{{AlertEnabled}}";
	$first = false;
	$last = false;
	$boolHideSplit = "{{HideSplitButton}}";
	$patternSelect = "{{patternSelect}}";
	$patternHideInput = "{{hidePatternInput}}";
	$GrepFilter = "{{GrepFilter}}";
	$saveGroupClass = "{{saveGroupClass}}";

	$selectOptions = array(
		0		=> array(
			"value" => ".log$",
			"name" => ".log"
		),
		1		=> array(
			"value" => ".txt$",
			"name" => ".txt"
		),
		2		=> array(
			"value" => ".out$",
			"name" => ".out"
		),
		3		=> array(
			"value" => "$",
			"name" => "Any File"
		)
	);

	$saveBlock = "<li class=\"watchRow ".$saveGroupClass." \" id=\"rowNumber".$rowNumber."\" ><div class=\"settingsHeader\" >";
	$saveBlock .= $fileNumber.":";
	$saveBlock .= "<div id=\"infoFile".$rowNumber."\" style=\"width: 100px; display: inline-block; text-align: center;\">";
	$saveBlock .= $filePermsDisplay;
	$saveBlock .= "</div>";
	$saveBlock .= "<span style=\"width: 50px; display: inline-block;\" id=\"imageFile".$rowNumber."\" >".$fileImage."</span>";
	$saveBlock .= "<input type=\"hidden\" name=\"watchListKey".$rowNumber."\" value=\"FileOrFolder".$rowNumber."\" >";
	$saveBlock .= "<a class=\"deleteIconPosition\"	onclick=\"deleteRowFunctionPopup(".$rowNumber.", '".$location."');\"	>";
	$localSrcMod = "";
	if(isset($data["srcModifier"]))
	{
		$localSrcMod = $data["srcModifier"];
	}
	$saveBlock .= $core->generateImage(
		$arrayOfImages["loadingImg"],
		array(
			"height"		=>	"25px",
			"srcModifier"	=>	$localSrcMod,
			"class"			=>	"watchlistImg",
			"data-src"		=>	$arrayOfImages["trashCanSideBar"]
		)
	);
	$saveBlock .= "</a>";
	$saveBlock .= "  <a ";
	if($first)
	{
		$saveBlock .= " style=\"display: none;\" ";
	}
	elseif(!isset($data["Position"]))
	{
		$saveBlock .= "{{moveup}}";
	}
	$saveBlock .= " class=\"linkSmall\" id=\"moveUp".$rowNumber."\" onclick=\"moveUp(".$rowNumber.");\" > Move Up </a>  <a ";
	if($last)
	{
		$saveBlock .= " style=\"display: none;\" ";
	}
	elseif(!isset($data["Position"]))
	{
		$saveBlock .= "{{movedown}}";
	}
	$saveBlock .= " class=\"linkSmall\" id=\"moveDown".$rowNumber."\" onclick=\"moveDown(".$rowNumber.");\" > Move Down </a>";
	$saveBlock .= "   <a onclick=\"duplicateRow(".$rowNumber.")\" class=\"linkSmall\"  >Duplicate</a>";
	$saveBlock .= "   <a id=\"SaveGroup".$rowNumber."\" onclick=\"toggleSaveGroup(".$rowNumber.")\" class=\"linkSmall\" > {{SaveGroupButton}} </a>";
	$saveBlock .= "   <a onclick=\"addFileFromLocation(".$rowNumber.");\" class=\"linkSmall\"> New file from base</a>";
	$saveBlock .= "   <a onclick=\"addFolderFromLocation(".$rowNumber.");\" class=\"linkSmall\"> New folder from base</a>";
	$saveBlock .= "</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\" >";
	$saveBlock .= "<li><span class=\"settingsBuffer\" >Location: </span><input onkeyup=\"getCurrentFileFolderMainPage(".$rowNumber.")\" onclick=\"showTypeDropdown(".$rowNumber.");\" style=\"width: 600px;\" type=\"text\" name=\"watchListKey".$rowNumber."Location\" value=\"".$location."\" ></li>";
	$saveBlock .= "<li  class=\"typeFile\" ".$typeFile."><span class=\"settingsBuffer\" >Pattern: </span><span class=\"settingsBuffer\" ><div class=\"selectDiv\"><select onchange=\"togglePatternSelect(".$rowNumber.")\" id=\"watchListKey".$rowNumber."PatternSelect\" >";
	if(isset($data["pattern"]))
	{
		$saveBlock .=  makePatternSelect($patternSelect, $selectOptions);
	}
	else
	{
		$saveBlock .=  $patternSelect;
	}
	$saveBlock .= "</select></div></span><span class=\"settingsBuffer\" ><input ".$patternHideInput." type=\"text\" onchange=\"updateSubFiles(".$rowNumber.");\"  name=\"watchListKey".$rowNumber."Pattern\" value=\"".$pattern."\" ></span></li>";
	$saveBlock .= "<input type=\"hidden\" name=\"watchListKey".$rowNumber."SaveGroup\" value=\"{{SaveGroupValue}}\"  >";
	$saveBlock .= "<span class=\"condensed\" ><li class=\"typeFile\" ".$typeFile."><span class=\"settingsBuffer\" >Recursive: </span><span class=\"settingsBuffer\" ><div class=\"selectDiv\"><select onchange=\"updateSubFiles(".$rowNumber.");\" name=\"watchListKey".$rowNumber."Recursive\" >";
	if(isset($data["recursiveOptions"]))
	{
		$saveBlock .=  makeTrueFalseSelect($recursiveOptions);
	}
	else
	{
		$saveBlock .=  $recursiveOptions;
	}
	$saveBlock .= "</select></div></span>";
	$saveBlock .= "<span class=\"settingsBuffer\" >Auto Delete Files After: </span><span class=\"settingsBuffer\" ><input style=\"width: 56px;\" type=\"text\" name=\"watchListKey".$rowNumber."AutoDeleteFiles\" value=\"".$AutoDeleteFiles."\" > Days No Change</span></li></span>";
	$saveBlock .= "<span class=\"condensed\" ><li  class=\"typeFolder\" ".$typeFolder."><span class=\"settingsBuffer\" >Name: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Name\" value=\"".$Name."\" > </span><span class=\"settingsBuffer\" >Filter: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."GrepFilter\" value=\"".$GrepFilter."\" > </span></li></span>";
	$saveBlock .= "<li>";
	$saveBlock .= "<span class=\"settingsBuffer\" >Group: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Group\" value=\"".$Group."\" ></span>";
	$saveBlock .= "<span class=\"settingsBuffer\" >FileType: </span><span class=\"settingsBuffer\" ><div class=\"selectDiv\"><select onchange=\"toggleTypeFolderFile(".$rowNumber.")\" name=\"watchListKey".$rowNumber."FileType\" >";
	if(isset($data["FileType"]))
	{
		$saveBlock .= generateFileTypeSelect($FileType);
	}
	else
	{
		$saveBlock .=  $FileType;
	}
	$saveBlock .= "</select></div></span></li>";
	$saveBlock .= "<span class=\"condensed\" ><li ><span class=\"settingsBuffer\" >Exclude Trim: </span><span class=\"settingsBuffer\" ><div class=\"selectDiv\"><select name=\"watchListKey".$rowNumber."ExcludeTrim\" >";
	if(isset($data["excludeTrimOptions"]))
	{
		$saveBlock .=   makeTrueFalseSelect($excludeTrimOptions);
	}
	else
	{
		$saveBlock .=  $excludeTrimOptions;
	}
	$saveBlock .= "</select></div></span>";
	$saveBlock .= "<span class=\"settingsBuffer\" >Alert on Update: </span><span class=\"settingsBuffer\" ><div class=\"selectDiv\"><select name=\"watchListKey".$rowNumber."AlertEnabled\" >";
	if(isset($data["AlertEnabled"]))
	{
		$saveBlock .=   makeTrueFalseSelect($AlertEnabled);
	}
	else
	{
		$saveBlock .=  $AlertEnabled;
	}
	$saveBlock .= "</select></div></span></li><span>";
	$saveBlock .= "<span class=\"condensed\" ><li class=\"typeFile\" ".$typeFile."><div class=\"settingsHeader\" style=\"margin: 0;\" >Files: ";
	$saveBlock .= "<div class=\"settingsHeaderButtons\"><span id=\"watchListKey".$rowNumber."SplitFilesLink\" ".$boolHideSplit." ><a class=\"linkSmall\" style=\"margin-right: 10px;\" onclick=\"updateSubFiles(".$rowNumber.");\" >Refresh</a><a class=\"linkSmall\" onclick=\"splitFilesPopup(".$rowNumber.", '".$location."');\"	 >Split Files</a></span></div>";
	$saveBlock .= "</div> <div class=\"settingsDiv\" style=\"max-height: 150px; display: block; overflow: auto; margin: 0;\" >";
	$saveBlock .= $core->generateImage(
		$arrayOfImages["loading"],
		array(
			"width"			=>	"25px",
			"id"			=>	"watchListKey".$rowNumber."LoadingSubFilesIcon",
			"style"			=>	"display: none;"
		)
	);
	$saveBlock .= "<ul id=\"watchListKey".$rowNumber."FilesInFolder\" class=\"settingsUl\" style=\"-webkit-padding-start: 0;\" >".$filesInFolder."</ul></div></li></span>";
	$saveBlock .= "<input type=\"hidden\"   name=\"watchListKey".$rowNumber."FileInformation\" value='".$FileInformation."' >";
	$saveBlock .= "</span></span></ul></div></li>";

	return $saveBlock;
}