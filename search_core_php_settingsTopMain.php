<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
		<div class="settingsHeader">
			Main Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
			
				<li>
					<span class="settingsBuffer" > Auto Check Update: </span> 
						<select id="settingsSelect" name="autoCheckUpdate">
								<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
								<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
						</select>

					<div id="settingsAutoCheckVars" <?php if($autoCheckUpdate == 'false'){echo "style='display: none;'";}?> >

					<div class="settingsHeader">
						Auto Check Update Settings
						</div>
						<div class="settingsDiv" >
						<ul id="settingsUl">
						
							<li>
							<span class="settingsBuffer" > Check for update every: </span> 
								<input type="text" name="autoCheckDaysUpdate" value="<?php echo $autoCheckDaysUpdate;?>" >  Day(s)
							</li>
							<li>
							<span class="settingsBuffer" > Notify Updates on: </span> 
								<select id="updateNoticeMeter" name="updateNoticeMeter">
			  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
			  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
								</select>
							</li>

						</ul>
						</div>
					</div>

				</li>
				<li>
					<span class="settingsBuffer" > Popup Warnings: </span> 
						<select id="popupSelect"  name="popupWarnings">
								<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
								<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
								<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
						</select>
					<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

					<div class="settingsHeader">
						Popup Settings
						</div>
						<div class="settingsDiv" >
						<ul id="settingsUl">
						<?php foreach ($popupSettingsArray as $key => $value):?>
							<li>
							<span class="settingsBuffer" > <?php echo $key;?>: </span> 
								<select name="<?php echo $key;?>">
			  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
			  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
								</select>
							</li>
						<?php endforeach;?>
						</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</form>