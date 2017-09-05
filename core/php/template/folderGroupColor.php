<form id="settingsColorFolderVars" action="../core/php/settingsSave.php" method="post">
	<div class="settingsHeader">
	Folder Color Options
	<div class="settingsHeaderButtons">
		<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderVars');" >Save Changes</a>
		<?php else: ?>
			<button  onclick="displayLoadingPopup();">Save Changes</button>
		<?php endif; ?>
	</div>
	</div>
	<div class="settingsDiv" >
		<ul id="settingsUl">
			<?php $i = 0;
			foreach ($folderColorArrays as $key => $value):
				$i++ ?>
				<li>
					<span class="settingsBuffer" > <input type="radio" name="currentFolderColorTheme" <?php if ($key == $currentFolderColorTheme){echo "checked='checked'";}?> value="<?php echo $key; ?>"> <?php echo $key; ?>: </span>  <input style="display: none;" type="text" name="folderColorThemeNameForPost<?php echo $i;?>" value="<?php echo $key; ?>" >
					<?php $j = 0;
					foreach ($value as $key2 => $value2):
						$j++;?>
						<div class="colorSelectorDiv" style="background-color: <?php echo $value2; ?>" >
							<!-- <div class="inner-triangle" ></div> -->
						</div>
						<input style="width: 100px; display: none;" type="text" name="folderColorValue<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2; ?>" >
					<?php endforeach; ?>
				</li>
			<?php endforeach; ?>
			<input style="display: none;" type="text" name="folderThemeCount" value="<?php echo $i; ?>">
		</ul>
	</div>
</form>