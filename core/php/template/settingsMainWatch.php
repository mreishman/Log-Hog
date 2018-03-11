<form onsubmit="checkWatchList()" id="settingsMainWatch" >
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
	</div>
</div>
<div class="settingsDiv" >	
<ul id="settingsUl">
	<?php

	$defaultTrashCanIcon = generateImage(
		$arrayOfImages["trashCan"],
		array(
			"height"		=>	"15px",
			"srcModifier"	=>	"../"
		)
	);

	function generateSaveBlock($data = array())
	{
		$rowNumber = "{{rowNumber}}";
		$fileNumber = "{{fileNumber}}";
		$filePermsDisplay = "{{filePermsDisplay}}";
		$fileImage = "{{fileImage}}";
		$location = "{{location}}";
		$pattern = "{{pattern}}";

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

		$saveBlock = "<li id=\"rowNumber".$rowNumber."\" >";
		$saveBlock .= "File ".$fileNumber.":";
		$saveBlock .= "<div id=\"infoFile".$rowNumber."\" style=\"width: 100px; display: inline-block; text-align: center;\">";
		$saveBlock .= $filePermsDisplay;
		$saveBlock .= "</div>";
		$saveBlock .= $fileImage;
		$saveBlock .=  "<input style=\"width: 480px;\" type=\"text\" name=\"watchListKey".$rowNumber."\" value=\"".$location."\" >";
		$saveBlock .= "<input type=\"text\" name=\"watchListItem".$rowNumber."\" value=\"".$pattern."\" >";
		$saveBlock .= "<a class=\"deleteIconPosition\"	onclick=\"deleteRowFunctionPopup(".$rowNumber.", true, '".$location."');\"	>";
		$saveBlock .= $defaultTrashCanIcon;
		$saveBlock .= "</a> </li>";

		return $saveBlock;
	}

	$i = 0;
	$triggerSaveUpdate = false;
	foreach($watchlist as $fileName => $values)
	{
		$i++;
		$location = $values["Location"];
		$pattern = $values["Pattern"];
		$info = filePermsDisplay($location);

		if(strpos($pattern, "\\") !== false)
		{
			$pattern = str_replace("\\", "", $pattern);
			$triggerSaveUpdate = true;
		}

		$fileImage = generateImage(
			$arrayOfImages["yellowWarning"],
			array(
				"width"			=>	"15px",
				"id"			=>	"fileNotFoundImage".$i,
				"srcModifier"	=>	"../"
			)
		);

		if(!file_exists($location))
		{
			$fileImage = generateImage(
				$arrayOfImages["redWarning"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}
		elseif(is_dir($location))
		{
			$fileImage = generateImage(
				$arrayOfImages["folderIcon"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}
		elseif(is_file($location))
		{
			$fileImage = generateImage(
				$arrayOfImages["fileIcon"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}

		echo generateSaveBlock(
			array(
				"rowNumber"			=>	$i,
				"fileNumber"		=>	$i,
				"filePermsDisplay"	=>	$info,
				"fileImage"			=>	$fileImage,
				"location"			=>	$location,
				"pattern"			=>	$pattern
			)
		);
	
	}
	?>

	<div id="newRowLocationForWatchList">
	</div>
</ul>
<ul id="settingsUl">
	<li>
		<a class="link" onclick="addRowFunction()">+ Add New File / Folder</a>
	</li>
	<li>
		<div class="settingsHeader">
			Key
		</div>
	</li>
	<li>
		<ul id="settingsUl">
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
				 - Folder
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
		<?php echo generateSaveBlock(); ?>
	</div>
</div>
<script type="text/javascript">
	var defaultTrashCanIcon = <?php echo json_encode($defaultTrashCanIcon); ?>
</script>
<?php $folderCount = $i;