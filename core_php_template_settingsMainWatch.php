<form onsubmit="checkWatchList()" id="settingsMainWatch" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
		<?php endif; ?>
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

	$i = 0;
	$triggerSaveUpdate = false;
	foreach($config['watchList'] as $key => $item):
		$i++;
		$info = filePermsDisplay($key);

		if(strpos($item, "\\") !== false)
		{
			$item = str_replace("\\", "", $item);
			$triggerSaveUpdate = true;
		}
		?>
	<li id="rowNumber<?php echo $i; ?>" >
		File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: 
		<div id="infoFile<?php echo $i;?>" style="width: 100px; display: inline-block; text-align: center;">
			<?php echo $info; ?>
		</div>
		
		<?php
		if(!file_exists($key))
		{
			echo generateImage(
				$arrayOfImages["redWarning"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}
		elseif(is_dir($key))
		{
			echo generateImage(
				$arrayOfImages["folderIcon"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}
		else
		{
			echo generateImage(
				$arrayOfImages["fileIcon"],
				array(
					"width"			=>	"15px",
					"id"			=>	"fileNotFoundImage".$i,
					"srcModifier"	=>	"../"
				)
			);
		}
		?> 
		
			<input 
				style='width: 480px;' 
				type='text'
				name='watchListKey<?php echo $i; ?>'
				value='<?php echo $key; ?>'
			>
			<input 
				type='text'
				name='watchListItem<?php echo $i; ?>'
				value='<?php echo $item; ?>'
			>
			<a 
				class="deleteIconPosition"
				onclick="deleteRowFunctionPopup(
					<?php echo $i; ?>,
					true,
					'<?php echo $key; ?>')"
			>
			<?php
				echo $defaultTrashCanIcon;
			?>
			</a>
	</li>

	<?php endforeach; ?>

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
<script type="text/javascript">
	var defaultTrashCanIcon = <?php echo json_encode($defaultTrashCanIcon); ?>
</script>
<?php $folderCount = $i;
