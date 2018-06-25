<form id="settingsWatchlistVars">
<div class="settingsHeader">
Watchlist Settings
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsWatchlistVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsWatchlistVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<li>
		<span class="settingsBuffer" >Default AlertEnabled:</span>
		<div class="selectDiv">
			<select name="defaultNewAddAlertEnabled">
				<option <?php if($defaultNewAddAlertEnabled == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($defaultNewAddAlertEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" >Default AutoDeleteFiles:</span>
		<input type="number" pattern="[0-9]*" name="defaultNewAddAutoDeleteFiles" value="<?php echo $defaultNewAddAutoDeleteFiles;?>" >
	</li>
	<li>
		<span class="settingsBuffer" >Default ExcludeTrim:</span>
		<div class="selectDiv">
			<select name="defaultNewAddExcludeTrim">
				<option <?php if($defaultNewAddExcludeTrim == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($defaultNewAddExcludeTrim == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" >Default Pattern:</span>
		<input type="text" name="defaultNewAddPattern" value="<?php echo $defaultNewAddPattern;?>" >
	</li>
	<li>
		<span class="settingsBuffer" >Default Recursive:</span>
		<div class="selectDiv">
			<select name="defaultNewAddRecursive">
				<option <?php if($defaultNewAddRecursive == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($defaultNewAddRecursive == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" >File popup sort:</span>
		<div class="selectDiv">
			<select name="sortTypeFileFolderPopup">
				<option <?php if($sortTypeFileFolderPopup == 'startsWithAndcontains'){echo "selected";} ?> value="startsWithAndcontains">Starts With > Contains > Other</option>
				<option <?php if($sortTypeFileFolderPopup == 'startsWith'){echo "selected";} ?> value="false">Starts With > Other</option>
				<option <?php if($sortTypeFileFolderPopup == 'none'){echo "selected";} ?> value="none">None</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>
