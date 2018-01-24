<form id="settingsMenuVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Menu Settings
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsMenuVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsMenuVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Truncate Log Button: </span>
		<div class="selectDiv">
			<select name="truncateLog">
				<option <?php if($truncateLog == 'true'){echo "selected";} ?> value="true">All Logs</option>
				<option <?php if($truncateLog == 'false'){echo "selected";} ?> value="false">Current Log</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Show Side Bar: </span>
		<div class="selectDiv">
			<select name="bottomBarIndexShow">
				<option <?php if($bottomBarIndexShow == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($bottomBarIndexShow == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li> 
		<span class="settingsBuffer" > Group
			<div class="selectDiv"> 
				<select name="groupByType">
					<option <?php if($groupByType == 'folder'){echo "selected";} ?> value="folder">Folders</option>
					<option <?php if($groupByType == 'file'){echo "selected";} ?> value="file">Files</option>
				</select>
			</div>
		 by color: </span>
		<div class="selectDiv">
			<select name="groupByColorEnabled">
					<option <?php if($groupByColorEnabled == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($groupByColorEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Notification Count </span>
		<div class="selectDiv">
			<select name="notificationCountVisible">
				<option <?php if($notificationCountVisible == 'true'){echo "selected";} ?> value="true">Enabled</option>
				<option <?php if($notificationCountVisible == 'false'){echo "selected";} ?> value="false">Disabled</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>