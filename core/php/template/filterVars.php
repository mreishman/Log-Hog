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
	<li>
		<span class="settingsBuffer" > Highlight Content match: </span>
		<div class="selectDiv">
			<select name="filterContentHighlight">
				<option <?php if($filterContentHighlight == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($filterContentHighlight == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Filter Content match: </span>
		<div class="selectDiv">
			<select id="filterContentLimit" name="filterContentLimit">
				<option <?php if($filterContentLimit == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($filterContentLimit == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
		<br>
		<span style="font-size: 75%;"><img style="margin-bottom: -4px;" id="aboutImage" src="<?php echo $localURL; ?>img/info.png" height="20px"> <i>When filtering by content, only show the line (or some sorrounding lines) containing the search content</i></span>
	</li>
	<li>
		<div id="filterContentSettings" style=" <?php if($filterContentLimit === 'false'){ echo 'display: none;'; }?> " >
			<div class="settingsHeader">
			Filter Content Match Settings
			</div>
			<div class="settingsDiv" >
				<ul id="settingsUl">
					<li>
						<span class="settingsBuffer" > Line Padding: </span>
						<div class="selectDiv">
							<select name="filterContentLinePadding">
								<option <?php if($filterContentLinePadding == 0){echo "selected";} ?> value=0>0</option>
								<option <?php if($filterContentLinePadding == 1){echo "selected";} ?> value=1>1</option>
								<option <?php if($filterContentLinePadding == 2){echo "selected";} ?> value=2>2</option>
								<option <?php if($filterContentLinePadding == 3){echo "selected";} ?> value=3>3</option>
								<option <?php if($filterContentLinePadding == 4){echo "selected";} ?> value=4>4</option>
								<option <?php if($filterContentLinePadding == 5){echo "selected";} ?> value=5>5</option>
								<option <?php if($filterContentLinePadding == 6){echo "selected";} ?> value=6>6</option>
								<option <?php if($filterContentLinePadding == 7){echo "selected";} ?> value=7>7</option>
								<option <?php if($filterContentLinePadding == 8){echo "selected";} ?> value=8>8</option>
								<option <?php if($filterContentLinePadding == 9){echo "selected";} ?> value=9>9</option>
							</select>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</li>
</ul>
</div>
</form>