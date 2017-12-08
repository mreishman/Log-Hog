<form id="settingsFilterVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Filter Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsFilterVars");
	if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsFilterVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Default Filter By: </span>
		<div class="selectDiv">
			<select name="filterDefault">
				<option <?php if($filterDefault == 'title'){echo "selected";} ?> value="title">Title</option>
				<option <?php if($filterDefault == 'content'){echo "selected";} ?> value="content">Content</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Case Insensitive Search: </span>
		<div class="selectDiv">
			<select name="caseInsensitiveSearch">
				<option <?php if($caseInsensitiveSearch == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($caseInsensitiveSearch == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>