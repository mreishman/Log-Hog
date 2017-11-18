<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Main Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsMainVars");
	if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Show Update Notification: </span>
		<div class="selectDiv">
			<select name="updateNotificationEnabled">
				<option <?php if($updateNotificationEnabled == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($updateNotificationEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Auto Check Update: </span>
		<div class="selectDiv">
			<select id="settingsSelect" name="autoCheckUpdate">
				<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
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
				<div class="selectDiv">
					<select id="updateNoticeMeter" name="updateNoticeMeter">
  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
					</select>
				</div>
				</li>

			</ul>
			</div>
		</div>

	</li>
	<li>
		<span class="settingsBuffer" > Popup Warnings: </span>
		<div class="selectDiv">
			<select id="popupSelect"  name="popupWarnings">
					<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
					<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
					<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
			</select>
		</div>
		<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

		<div class="settingsHeader">
			Popup Settings
			</div>
			<div class="settingsDiv" >
			<ul id="settingsUl">
			<?php foreach ($popupSettingsArray as $key => $value):?>
				<li>
				<span class="settingsBuffer" > <?php echo $key;?>: </span>
				<div class="selectDiv">
					<select name="<?php echo $key;?>">
  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
					</select>
				</div>
				</li>
			<?php endforeach;?>
			</ul>
			</div>
		</div>
	</li>
</ul>
</div>
</form>