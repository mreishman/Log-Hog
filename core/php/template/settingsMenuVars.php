<form id="settingsMenuVars" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
		Menu Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				<span class="settingsBuffer" > Hide logs that are empty: </span>
				<select name="hideEmptyLog">
						<option <?php if($hideEmptyLog == 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($hideEmptyLog == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
				
			</li>
			<li>
				<span class="settingsBuffer" > Group 
					<select name="groupByType">
						<option <?php if($groupByType == 'folder'){echo "selected";} ?> value="folder">Folders</option>
						<option <?php if($groupByType == 'file'){echo "selected";} ?> value="file">Files</option>
					</select>
				 by color: </span>
				<select name="groupByColorEnabled">
						<option <?php if($groupByColorEnabled == 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($groupByColorEnabled == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
				<div class="settingsHeader">
					Folder Group Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
						<?php $i = 0; foreach ($folderColorArrays as $key => $value): $i++ ?>
							<li>
								<span class="settingsBuffer" > <input type="radio" name="currentFolderColorTheme" <?php if ($key == $currentFolderColorTheme){echo "checked='checked'";}?> value="<?php echo $key; ?>"> <?php echo $key; ?>: </span>  <input style="display: none;" type="text" name="folderColorThemeNameForPost<?php echo $i;?>" value="<?php echo $key; ?>" >
								<?php $j = 0; foreach ($value as $key2 => $value2): $j++;?>
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
				</div>
			</li>
		</ul>
		</div>
		</form>