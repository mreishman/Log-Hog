<form onsubmit="checkWatchList()" id="settingsMainWatch" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
		<?php else: ?>
			<button  onclick="displayLoadingPopup();">Save Changes</button>
		<?php endif; ?>
	</div>
</div>
<div class="settingsDiv" >	
<ul id="settingsUl">
	<?php
		$i = 0;
		$triggerSaveUpdate = false;
		foreach($config['watchList'] as $key => $item): $i++;
		$info = filePermsDisplay($key);

		if(strpos($item, "\\") !== false)
		{
			$item = str_replace("\\", "", $item);
			$triggerSaveUpdate = true;
		}
		?>
	<li id="rowNumber<?php echo $i; ?>" >
		File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: 
		<div style="width: 100px; display: inline-block; text-align: center;">
			<?php echo $info; ?>
		</div>
		<img id=
		<?php
		if(!file_exists($key))
		{
			echo '"fileNotFoundImage'.$i.'" src="'.$baseUrlImages.'img/redWarning.png"';
		}
		elseif(is_dir($key))
		{
			echo '"fileNotFoundImage'.$i.'" src="'.$baseUrlImages.'img/folderIcon.png"';
		}
		else
		{
			echo '"fileNotFoundImage'.$i.'" src="'.$baseUrlImages.'img/fileIcon.png"';
		}
		?> 
		width="15px">
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
				<img src="<?php echo $baseUrlImages;?>img/trashCan.png" height="15px;" >
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
				<img src="<?php echo $baseUrlImages;?>img/redWarning.png" height="10px"> - File / Folder not found! &nbsp; &nbsp; &nbsp; 
				<img src="<?php echo $baseUrlImages;?>img/fileIcon.png" height="10px"> - File &nbsp; &nbsp; &nbsp; 
				<img src="<?php echo $baseUrlImages;?>img/folderIcon.png" height="10px"> - Folder
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
<?php $folderCount = $i;