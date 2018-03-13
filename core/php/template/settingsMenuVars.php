<form id="settingsMenuVars">
<div class="settingsHeader">
Menu Settings
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsMenuVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsMenuVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<li>
		<span class="settingsBuffer" > Truncate Log Button: </span>
		<div class="selectDiv">
			<select name="truncateLog">
				<option <?php if($truncateLog == 'true'){echo "selected";} ?> value="true">All Logs</option>
				<option <?php if($truncateLog == 'false'){echo "selected";} ?> value="false">Current Log</option>
				<option <?php if($truncateLog == 'hide'){echo "selected";} ?> value="hide">Hide</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" >Clear Notifications Button:</span>
		<div class="selectDiv">
			<select name="hideClearAllNotifications">
				<option <?php if($hideClearAllNotifications == 'true'){echo "selected";} ?> value="true">Hide</option>
				<option <?php if($hideClearAllNotifications == 'false'){echo "selected";} ?> value="false">Show</option>
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
		<span class="settingsBuffer" > Hide logs that are empty: </span>
			<div class="selectDiv">
				<select name="hideEmptyLog">
					<option <?php if($hideEmptyLog == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($hideEmptyLog == 'false'){echo "selected";} ?> value="false">False</option>
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
	<li>
		<span class="settingsBuffer" > On Log Title Hover Show: </span>
		<div class="selectDiv">
			<select name="logTitle">
				<option <?php if($logTitle == 'lastLine'){echo "selected";} ?> value="lastLine">Last Line In Log</option>
				<option <?php if($logTitle == 'filePath'){echo "selected";} ?> value="filePath">Full Path Of Log</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Log List Location: </span>
			<div class="selectDiv">
				<select name="logMenuLocation">
					<option <?php if($logMenuLocation == 'top'){echo "selected";} ?> value="top">Top</option>
					<option <?php if($logMenuLocation == 'bottom'){echo "selected";} ?> value="bottom">Bottom</option>
					<option <?php if($logMenuLocation == 'left'){echo "selected";} ?> value="left">Left</option>
					<option <?php if($logMenuLocation == 'right'){echo "selected";} ?> value="right">Right</option>
				</select>
			</div>
		</li>
	</li>
</ul>
</div>
</form>