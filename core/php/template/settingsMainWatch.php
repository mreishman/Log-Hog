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
		$saveBlock .= "</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\" >";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Location: </span><input style=\"width: 600px;\" type=\"text\" name=\"watchListKey".$rowNumber."Location\" value=\"".$location."\" ></li>";
		$saveBlock .= "<li ".$typeFile."><span class=\"settingsBuffer\" >Pattern: </span><span class=\"settingsBuffer\" ><input type=\"text\" name=\"watchListKey".$rowNumber."Pattern\" value=\"".$pattern."\" ></span>";
		$saveBlock .= "<span class=\"settingsBuffer\" >Recursive: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."Recursive\" >";
		if(isset($data["recursiveOptions"]))
		{
			$saveBlock .=  "<option value=\"true\" ";
			if($recursiveOptions === 'true')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >True</option>";
			$saveBlock .=  "<option value=\"false\" ";
			if($recursiveOptions !== 'true')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >False</option>";
		}
		else
		{
			$saveBlock .=  $recursiveOptions;
		}
		$saveBlock .= "</select></span></li>";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Exclude Trim: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."ExcludeTrim\" >";
		if(isset($data["excludeTrimOptions"]))
		{
			$saveBlock .=  "<option value=\"true\" ";
			if($excludeTrimOptions === 'true')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >True</option>";
			$saveBlock .=  "<option value=\"false\" ";
			if($excludeTrimOptions !== 'true')
			{
				$saveBlock .= " selected ";
			}
			$saveBlock .= "  >False</option>";
		}
		else
		{
			$saveBlock .=  $excludeTrimOptions;
		}
		$saveBlock .= "</select></span>";
		$saveBlock .= "<span class=\"settingsBuffer\" >FileType: </span><span class=\"settingsBuffer\" ><select name=\"watchListKey".$rowNumber."FileType\" >";
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
		$saveBlock .= "<li ".$typeFile."><div class=\"settingsHeader\" style=\"margin: 0;\" >Files: ";
		$saveBlock .= "<div class=\"settingsHeaderButtons\"><a class=\"linkSmall\" onclick=\"splitFilesPopup(".$rowNumber.", '".$location."');\"	 >Split Files</a></div>";
		$saveBlock .= "</div> <div class=\"settingsDiv\" style=\"max-height: 150px; display: block; overflow: auto; margin: 0;\" ><ul id=\"watchListKey".$rowNumber."FilesInFolder\" class=\"settingsUl\" style=\"-webkit-padding-start: 0;\" >".$filesInFolder."</ul></div> </li>";
		$saveBlock .= "</ul></div></li>";

		return $saveBlock;
	}

	$i = 0;
	$triggerSaveUpdate = false;
	foreach($watchList as $key => $values)
	{
		$i++;
		$location = $values["Location"];
		$info = filePermsDisplay($location);
		$filesInFolder = "";
		$fileImage = $defaultYellowErrorIcon;
		$FileType = "auto";

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
			foreach ($response as $key2)
			{
				$filesInFolder .= "<li>";
				$filesInFolder .= $defaultFileIcon;
				$filesInFolder .= "<span style=\"width: 300px; overflow: auto; display: inline-block;\" >".str_replace($location, "", $key2)."</span><input name=\"watchListKey".$i."FileInFolder\"  type=\"hidden\" value=\"".$key2."\" >";
				$filesInFolder .= "<span class=\"settingsBuffer\" > <input type=\"checkbox\" checked > Include </span>";
				$filesInFolder .= "<span class=\"settingsBuffer\" > <input type=\"checkbox\" checked > Trim </span>";
				$filesInFolder .= "</li>";
			}
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>No Files Found In Folder</li>";
			}
			//$fileSize = 
		}
		elseif($FileType === "file")
		{
			//$fileSize = 
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>FileType was set to file</li>";
			}
		}
		else
		{
			if($filesInFolder === "")
			{
				$filesInFolder = "<li>No Files Found</li>";
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
				"filesInFolder"			=>	$filesInFolder
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
	var defaultTrashCanIcon = <?php echo json_encode($defaultTrashCanIcon); ?>
</script>
<?php $folderCount = $i;