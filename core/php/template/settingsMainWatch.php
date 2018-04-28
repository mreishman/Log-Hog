<form onsubmit="checkWatchList()" id="settingsMainWatch" >
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
	</div>
</div>
<div class="settingsDiv" >	
<ul class="settingsUl uniqueClassForAppendSettingsMainWatchNew" style=" -webkit-padding-start: 0;" >
	<?php

	$defaultTrashCanIcon = generateImage(
		$arrayOfImages["trashCanSideBar"],
		array(
			"height"		=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultRedErrorIcon = generateImage(
		$arrayOfImages["redWarning"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultYellowErrorIcon = generateImage(
		$arrayOfImages["yellowWarning"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFolderIcon = generateImage(
		$arrayOfImages["folderIcon"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFileIcon = generateImage(
		$arrayOfImages["fileIcon"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFolderNRIcon = generateImage(
		$arrayOfImages["folderIconNR"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFileNRIcon = generateImage(
		$arrayOfImages["fileIconNR"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFolderNWIcon = generateImage(
		$arrayOfImages["folderIconNW"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFileNWIcon = generateImage(
		$arrayOfImages["fileIconNW"],
		array(
			"width"			=>	"25px",
			"srcModifier"	=>	"../"
		)
	);

	function makeTrueFalseSelect($boolVal)
	{
		$optionBlock =  "<option value=\"true\" ";
		if($boolVal === 'true')
		{
			$optionBlock .= " selected ";
		}
		$optionBlock .= "  >True</option>";
		$optionBlock .=  "<option value=\"false\" ";
		if($boolVal !== 'true')
		{
			$optionBlock .= " selected ";
		}
		$optionBlock .= "  >False</option>";
		return $optionBlock;
	}


	function generateSaveBlock($data = array(), $defaultTrashCanIcon)
	{
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

		if(isset($data["hideSplitButton"]))
		{
			if($data["hideSplitButton"] === true)
			{
				$boolHideSplit = "style=\"display: none;\"";
			}
		}

		if(isset($data["Position"]))
		{
			if($data["Position"] === "first")
			{
				$first = true;
			}
			elseif($data["Position"] === "last")
			{
				$last = true;
			}
		}

		if(isset($data["rowNumber"]))
		{
			$rowNumber = $data["rowNumber"];
		}

		if(isset($data["fileNumber"]))
		{
			$fileNumber = $data["fileNumber"];
			if ($fileNumber < 10)
			{
				$fileNumber = "0".$fileNumber;
			}
		}

		if(isset($data["filePermsDisplay"]))
		{
			$filePermsDisplay = $data["filePermsDisplay"];
		}

		if(isset($data["fileImage"]))
		{
			$fileImage = $data["fileImage"];
		}

		if(isset($data["location"]))
		{
			$location = $data["location"];
		}

		if(isset($data["pattern"]))
		{
			$pattern = $data["pattern"];
		}

		if(isset($data["key"]))
		{
			$key = $data["key"];
		}

		if(isset($data["recursiveOptions"]))
		{
			$recursiveOptions = $data["recursiveOptions"];
		}

		if(isset($data["excludeTrimOptions"]))
		{
			$excludeTrimOptions = $data["excludeTrimOptions"];
		}

		if(isset($data["FileType"]))
		{
			$FileType = $data["FileType"];
		}

		if(isset($data["filesInFolder"]))
		{
			$filesInFolder = $data["filesInFolder"];
		}

		if(isset($data["AutoDeleteFiles"]))
		{
			$AutoDeleteFiles = $data["AutoDeleteFiles"];
		}

		if(isset($data["Group"]))
		{
			$Group = $data["Group"];
		}

		if(isset($data["FileInformation"]))
		{
			$FileInformation = $data["FileInformation"];
		}

		if(isset($data["Name"]))
		{
			$Name = $data["Name"];
		}

		if(isset($data["AlertEnabled"]))
		{
			$AlertEnabled = $data["AlertEnabled"];
		}		

		if(isset($data["typeFolder"]))
		{
			if($data["typeFolder"] == true)
			{
				$typeFolder = " style=\" display: none; \" ";
			}
			else
			{
				$typeFolder = "";
			}
		}

		if(isset($data["typeFile"]))
		{
			if($data["typeFile"] == true)
			{
				$typeFile = " style=\" display: none; \" ";
			}
			else
			{
				$typeFile = "";
			}
		}
		

		$saveBlock = "<li class=\"watchRow\" id=\"rowNumber".$rowNumber."\" ><div class=\"settingsHeader\" >";
		$saveBlock .= "File ".$fileNumber.":";
		$saveBlock .= "<div id=\"infoFile".$rowNumber."\" style=\"width: 100px; display: inline-block; text-align: center;\">";
		$saveBlock .= $filePermsDisplay;
		$saveBlock .= "</div>";
		$saveBlock .= "<span style=\"width: 50px; display: inline-block;\" id=\"imageFile".$rowNumber."\" >".$fileImage."</span>";
		$saveBlock .= "<input type=\"hidden\" name=\"watchListKey".$rowNumber."\" value=\"FileOrFolder".$rowNumber."\" >";
		$saveBlock .= "<a class=\"deleteIconPosition\"	onclick=\"deleteRowFunctionPopup(".$rowNumber.", '".$location."');\"	>";
		$saveBlock .= $defaultTrashCanIcon;
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
		$saveBlock .= "</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\" >";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Location: </span><input style=\"width: 600px;\" type=\"text\" name=\"watchListKey".$rowNumber."Location\" value=\"".$location."\" ></li>";
		$saveBlock .= "<li  class=\"typeFile\" ".$typeFile."><span class=\"settingsBuffer\" >Pattern: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Pattern\" value=\"".$pattern."\" ></span>";
		$saveBlock .= "<span class=\"settingsBuffer\" >Recursive: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."Recursive\" >";
		if(isset($data["recursiveOptions"]))
		{
			$saveBlock .=  makeTrueFalseSelect($recursiveOptions);
		}
		else
		{
			$saveBlock .=  $recursiveOptions;
		}
		$saveBlock .= "</select></span></li>";
		$saveBlock .= "<li class=\"typeFile\" ".$typeFile."><span class=\"settingsBuffer\" >Auto Delete Files After: </span><span class=\"settingsBuffer\" ><input style=\"width: 56px;\" type=\"text\" name=\"watchListKey".$rowNumber."AutoDeleteFiles\" value=\"".$AutoDeleteFiles."\" > Days No Change</span></li>";
		$saveBlock .= "<li  class=\"typeFolder\" ".$typeFolder."><span class=\"settingsBuffer\" >Name: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Name\" value=\"".$Name."\" > </span></li>";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Exclude Trim: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."ExcludeTrim\" >";
		if(isset($data["excludeTrimOptions"]))
		{
			$saveBlock .=   makeTrueFalseSelect($excludeTrimOptions);
		}
		else
		{
			$saveBlock .=  $excludeTrimOptions;
		}
		$saveBlock .= "</select></span>";
		$saveBlock .= "<span class=\"settingsBuffer\" >FileType: </span><span class=\"settingsBuffer\" ><select onchange=\"toggleTypeFolderFile(".$rowNumber.")\" name=\"watchListKey".$rowNumber."FileType\" >";
		if(isset($data["FileType"]))
		{
			$saveBlock .=  "<option value=\"file\" ";
			if($FileType === 'file')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >File</option>";
			$saveBlock .=  "<option value=\"folder\" ";
			if($FileType === 'folder')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >Folder</option>";
			$saveBlock .=  "<option value=\"other\" ";
			if($FileType !== 'folder' && $FileType !== 'file')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >Other</option>";
		}
		else
		{
			$saveBlock .=  $FileType;
		}
		$saveBlock .= "</select></span></li>";
		$saveBlock .= "<li ><span class=\"settingsBuffer\" >Group: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Group\" value=\"".$Group."\" ></span>";
		$saveBlock .= "<span class=\"settingsBuffer\" >Alert on Update: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."AlertEnabled\" >";
		if(isset($data["AlertEnabled"]))
		{
			$saveBlock .=   makeTrueFalseSelect($AlertEnabled);
		}
		else
		{
			$saveBlock .=  $AlertEnabled;
		}
		$saveBlock .= "</select></span></li>";
		$saveBlock .= "<li class=\"typeFile\" ".$typeFile."><div class=\"settingsHeader\" style=\"margin: 0;\" >Files: ";
		$saveBlock .= "<div class=\"settingsHeaderButtons\"><a id=\"watchListKey".$rowNumber."SplitFilesLink\" ".$boolHideSplit." class=\"linkSmall\" onclick=\"splitFilesPopup(".$rowNumber.", '".$location."');\"	 >Split Files</a></div>";
		$saveBlock .= "</div> <div class=\"settingsDiv\" style=\"max-height: 150px; display: block; overflow: auto; margin: 0;\" ><ul id=\"watchListKey".$rowNumber."FilesInFolder\" class=\"settingsUl\" style=\"-webkit-padding-start: 0;\" >".$filesInFolder."</ul></div></li>";
		$saveBlock .= "<input type=\"hidden\"   name=\"watchListKey".$rowNumber."FileInformation\" value='".$FileInformation."' >";
		$saveBlock .= "</ul></div></li>";

		return $saveBlock;
	}

	$i = 0;
	$triggerSaveUpdate = false;
	$total = count($watchList);
	foreach($watchList as $key => $values)
	{
		$i++;
		$location = $values["Location"];
		$info = filePermsDisplay($location);
		$filesInFolder = "";
		$fileImage = $defaultYellowErrorIcon;
		$FileType = "auto";
		$FileInformation = $values["FileInformation"];
		$Position = false;
		$boolHideSplit = false;
		if($i === 1)
		{
			$Position = "first";
		}
		elseif($total === $i)
		{
			$Position = "last";
		}

		if(!file_exists($location))
		{
			$fileImage = $defaultRedErrorIcon;
		}
		elseif(is_dir($location))
		{
			$fileImage = $defaultFolderIcon;
			if($FileType !== "other")
			{
				$FileType = "folder";
			}
			if(!is_readable($location))
			{
				$fileImage = $defaultFolderNRIcon;
			}
			elseif(!is_writeable($location))
			{
				$fileImage = $defaultFolderNWIcon;
			}
		}
		elseif(is_file($location))
		{
			$fileImage = $defaultFileIcon;
			if($FileType !== "other")
			{
				$FileType = "file";
			}
			if(!is_readable($location))
			{
				$fileImage = $defaultFileNRIcon;
			}
			elseif(!is_writeable($location))
			{
				$fileImage = $defaultFileNWIcon;
			}
		}

		if($values["FileType"] != "auto")
		{
			$FileType = $values["FileType"];
		}
		$fileSize = "";

		if($FileType === "folder")
		{
			$response = array();
			if(file_exists($location))
			{
				$response = getListOfFiles(array(
					"path" 			=> $location,
					"filter"		=> $values["Pattern"],
					"response"		=> array(),
					"recursive"		=> $values["Recursive"]

				));
			}
			$fileData = array();
			$tmpFileData = json_decode($values["FileInformation"]);
			if(!is_null($tmpFileData))
			{
				$fileData = get_object_vars($tmpFileData);
			}
			foreach ($response as $key2)
			{
				$filesInFolder .= "<li>";
				
				if(!is_readable($key2))
				{
					$filesInFolder .= $defaultFileNRIcon;
				}
				elseif(!is_writeable($key2))
				{
					$filesInFolder .= $defaultFileNWIcon;
				}
				else
				{
					$filesInFolder .= $defaultFileIcon;
				}

				$includeBool = "true";
				$excludeTrimBool = $defaultNewAddExcludeTrim;
				$excludeDelete = "false";
				$nameValue = "";
				$notify = $defaultNewAddAlertEnabled;
				if(isset($fileData[$key2]))
				{
					$dataToUse = array();
					$tmpFileData = get_object_vars($fileData[$key2]);
					if(!is_null($tmpFileData) || empty($tmpFileData))
					{
						$dataToUse = $tmpFileData;
					}
					if(isset($dataToUse["Include"]))
					{
						$includeBool = $dataToUse["Include"];
					}
					if(isset($dataToUse["Trim"]))
					{
						$excludeTrimBool = $dataToUse["Trim"];
					}
					if(isset($dataToUse["Delete"]))
					{
						$excludeDelete = $dataToUse["Delete"];
					}
					if(isset($dataToUse["Name"]))
					{
						$nameValue = $dataToUse["Name"];
					}
					if(isset($dataToUse["Alert"]))
					{
						$notify = $dataToUse["Alert"];
					}
				}

				$filesInFolder .= "<span style=\"width: 300px; overflow: auto; display: inline-block;\" >".str_replace($location, "", $key2)."</span><input name=\"watchListKey".$i."FileInFolder\"  type=\"hidden\" value=\"".$key2."\" >";
				$filesInFolder .= "<span class=\"settingsBuffer\" >Include: <select onchange=\"updateFileInfo(".$i.");\" name=\"watchListKey".$i."FileInFolderInclude\" > ".makeTrueFalseSelect($includeBool)." </select></span>";
				$filesInFolder .= "<span class=\"settingsBuffer\" >Exclude Trim: <select onchange=\"updateFileInfo(".$i.");\" name=\"watchListKey".$i."FileInFolderTrim\"> ".makeTrueFalseSelect($excludeTrimBool)." </select></span>";
				$filesInFolder .= "<span class=\"settingsBuffer\" >Exclude Delete: <select onchange=\"updateFileInfo(".$i.");\" name=\"watchListKey".$i."ExcludeDelete\"> ".makeTrueFalseSelect($excludeDelete)." </select></span>";
				$filesInFolder .= "<span class=\"settingsBuffer\" >Alert on Update: <select onchange=\"updateFileInfo(".$i.");\" name=\"watchListKey".$i."FileInFolderAlert\"> ".makeTrueFalseSelect($notify)." </select></span>";

				$filesInFolder .= "<span class=\"settingsBuffer\" >Name: <input onchange=\"updateFileInfo(".$i.");\"  type=\"text\" name=\"watchListKey".$i."FileInFolderName\" value=\"".$nameValue."\" > </span>";
				$filesInFolder .= "</li>";
			}
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>No Files Found In Folder</li>";
				$boolHideSplit = true;
			}
			//$fileSize = 
		}
		elseif($FileType === "file")
		{
			//$fileSize = 
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>FileType was set to file</li>";
				$boolHideSplit = true;
			}
		}
		else
		{
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>No Files Found</li>";
				$boolHideSplit = true;
			}
		}

		

		echo generateSaveBlock(
			array(
				"rowNumber"				=>	$i,
				"fileNumber"			=>	$i,
				"filePermsDisplay"		=>	$info,
				"fileImage"				=>	$fileImage,
				"location"				=>	$location,
				"pattern"				=>	$values["Pattern"],
				"key"					=>	$key,
				"recursiveOptions"		=>	$values["Recursive"],
				"excludeTrimOptions"	=>	$values["ExcludeTrim"],
				"typeFile"				=>	($FileType === "file"),
				"typeFolder"			=>	($FileType === "folder"),
				"FileType"				=> 	$FileType,
				"filesInFolder"			=>	$filesInFolder,
				"hideSplitButton"		=>	$boolHideSplit,
				"AutoDeleteFiles"		=>	$values["AutoDeleteFiles"],
				"Group"					=>	$values["Group"],
				"FileInformation"		=>	$FileInformation,
				"Name"					=>	$values["Name"],
				"AlertEnabled"			=>	$values["AlertEnabled"],
				"Position"				=>	$Position
			),
			$defaultTrashCanIcon
		);
	
	}
	?>
</ul>
<ul class="settingsUl">
	<li>
		<a class="link" onclick="addFile();">+ Add New File</a>
		<a class="link" onclick="addFolder();">+ Add New Folder</a>
		<a class="link" onclick="addOther();">+ Add Other</a>
	</li>
	<li>
		<div class="settingsHeader">
			Key
		</div>
	</li>
	<li> 
		<ul class="settingsUl">
			<li>
				<?php
					echo generateImage(
						$arrayOfImages["redWarning"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - File / Folder not found! &nbsp; &nbsp; &nbsp; 
				<?php 
					echo generateImage(
						$arrayOfImages["yellowWarning"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - Unknown
			</li>
			<li>
				<?php
					echo generateImage(
						$arrayOfImages["fileIcon"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - File &nbsp; &nbsp; &nbsp; 
				<?php
					echo generateImage(
						$arrayOfImages["fileIconNR"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - File Not Readable &nbsp; &nbsp; &nbsp; 
				<?php
					echo generateImage(
						$arrayOfImages["fileIconNW"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - File Not Writeable
			</li>
			<li>
				<?php
					echo generateImage(
						$arrayOfImages["folderIcon"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - Folder &nbsp; &nbsp; &nbsp; 
				<?php
					echo generateImage(
						$arrayOfImages["folderIconNR"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - Folder Not Readable &nbsp; &nbsp; &nbsp; 
				<?php
					echo generateImage(
						$arrayOfImages["folderIconNW"],
						array(
							"height"		=>	"10px",
							"srcModifier"	=>	"../"
						)
					);
				?>
				 - Folder Not Writeable &nbsp; &nbsp; &nbsp; 
			</li>
			<li>
				f - file &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
				d - directory &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
				u - unknown / file not found &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
				r - readable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
				w - writeable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
				x - executable
			</li>
		</ul>
	</li>
</ul>
</div>
<div id="hidden" style="display: none">
	<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
</div>	
</form>
<div id="storage">
	<div class="saveBlock">
		<?php echo generateSaveBlock(array(), $defaultTrashCanIcon); ?>
	</div>
</div>
<script type="text/javascript">
	var defaultTrashCanIcon 				= <?php echo json_encode($defaultTrashCanIcon); ?>;
	var icons = {};
	icons["defaultRedErrorIcon"]				= <?php echo json_encode($defaultRedErrorIcon); ?>;
	icons["defaultYellowErrorIcon "]				= <?php echo json_encode($defaultYellowErrorIcon); ?>;
	icons["defaultFolderIcon"] 					= <?php echo json_encode($defaultFolderIcon); ?>;
	icons["defaultFileIcon"] 					= <?php echo json_encode($defaultFileIcon); ?>;
	icons["defaultFolderNRIcon"] 				= <?php echo json_encode($defaultFolderNRIcon); ?>;
	icons["defaultFileNRIcon"] 					= <?php echo json_encode($defaultFileNRIcon); ?>;
	icons["defaultFolderNWIcon"] 				= <?php echo json_encode($defaultFolderNWIcon); ?>;
	icons["defaultFileNWIcon"] 					= <?php echo json_encode($defaultFileNWIcon); ?>;
	var defaultdefaultNewAddAlertEnabled 	= "<?php echo $defaultNewAddAlertEnabled; ?>";
	var defaultNewAddAutoDeleteFiles 		= "<?php echo $defaultNewAddAutoDeleteFiles; ?>";
	var defaultNewAddExcludeTrim 			= "<?php echo $defaultNewAddExcludeTrim; ?>";
	var defaultNewAddPattern 				= "<?php echo $defaultNewAddPattern;?>";
	var defaultNewAddRecursive 				= "<?php echo $defaultNewAddRecursive;?>";
	var defaultNewPathFile 					= "<?php echo $defaultNewPathFile; ?>";
	var defaultNewPathFolder				= "<?php echo $defaultNewPathFolder;?>";
	var defaultNewPathOther 				= "<?php echo $defaultNewPathOther;?>";
</script>
<?php $folderCount = $i;