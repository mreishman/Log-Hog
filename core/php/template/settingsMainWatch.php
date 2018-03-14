<form onsubmit="checkWatchList()" id="settingsMainWatch" >
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
	</div>
</div>
<div class="settingsDiv" >	
<ul class="settingsUl uniqueClassForAppendSettingsMainWatchNew">
	<?php

	$defaultTrashCanIcon = generateImage(
		$arrayOfImages["trashCan"],
		array(
			"height"		=>	"15px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultRedErrorIcon = generateImage(
		$arrayOfImages["redWarning"],
		array(
			"width"			=>	"15px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultYellowErrorIcon = generateImage(
		$arrayOfImages["yellowWarning"],
		array(
			"width"			=>	"15px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFolderIcon = generateImage(
		$arrayOfImages["folderIcon"],
		array(
			"width"			=>	"15px",
			"srcModifier"	=>	"../"
		)
	);

	$defaultFileIcon = generateImage(
		$arrayOfImages["fileIcon"],
		array(
			"width"			=>	"15px",
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

		$saveBlock = "<li class=\"watchRow\" id=\"rowNumber".$rowNumber."\" >";
		$saveBlock .= "File ".$fileNumber.":";
		$saveBlock .= "<div id=\"infoFile".$rowNumber."\" style=\"width: 100px; display: inline-block; text-align: center;\">";
		$saveBlock .= $filePermsDisplay;
		$saveBlock .= "</div>";
		$saveBlock .= "<span style=\"width: 25px; display: inline-block;\" id=\"imageFile".$rowNumber."\" >".$fileImage."</span>";
		$saveBlock .= "<input type=\"hidden\" name=\"watchListKey".$rowNumber."\" value=\"FileOrFolder".$rowNumber."\" >";
		$saveBlock .= "<a class=\"deleteIconPosition\"	onclick=\"deleteRowFunctionPopup(".$rowNumber.", '".$location."');\"	>";
		$saveBlock .= $defaultTrashCanIcon;
		$saveBlock .= "</a>";
		$saveBlock .= "<br><ul class=\"settingsUl\" >";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Location: </span><input style=\"width: 480px;\" type=\"text\" name=\"watchListKey".$rowNumber."Location\" value=\"".$location."\" ></li>";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Pattern: </span><input type=\"text\" name=\"watchListKey".$rowNumber."Pattern\" value=\"".$pattern."\" ></li>";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Recursive: </span><select name=\"watchListKey".$rowNumber."Recursive\" >";
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
		$saveBlock .= "</select></li>";
		$saveBlock .= "<li><span class=\"settingsBuffer\" >Exclude Trim: </span><select name=\"watchListKey".$rowNumber."ExcludeTrim\" >";
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
		$saveBlock .= "</select></li>";
		$saveBlock .= "</ul></li>";

		return $saveBlock;
	}

	$i = 0;
	$triggerSaveUpdate = false;
	foreach($watchList as $key => $values)
	{
		$i++;
		$location = $values["Location"];
		$info = filePermsDisplay($location);

		$fileImage = $defaultYellowErrorIcon;

		if(!file_exists($location))
		{
			$fileImage = $defaultRedErrorIcon;
		}
		elseif(is_dir($location))
		{
			if(is_readable($location))
			{
				//add icon here?
			}
			$fileImage = $defaultFolderIcon;
		}
		elseif(is_file($location))
		{
			if(is_readable($location))
			{
				//add icon here?
			}
			$fileImage = $defaultFileIcon;
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
				"excludeTrimOptions"	=>	$values["ExcludeTrim"]
			),
			$defaultTrashCanIcon
		);
	
	}
	?>
</ul>
<ul class="settingsUl">
	<li>
		<a class="link" onclick="addRowFunction()">+ Add New File / Folder</a>
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