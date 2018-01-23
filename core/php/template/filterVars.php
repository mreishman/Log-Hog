<form id="settingsFilterVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Filter Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsFilterVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsFilterVars');" >Save Changes</a>
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
			<select id="filterContentHighlight" name="filterContentHighlight">
				<option <?php if($filterContentHighlight == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($filterContentHighlight == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<div id="highlightContentSettings" style=" <?php if($filterContentHighlight == 'false'){ echo 'display: none;'; }?> " >
			<div class="settingsHeader">
			Filter Highlight Settings
			</div>
			<div class="settingsDiv" >
				<ul id="settingsUl">
					<li>
						<span class="settingsBuffer" > Background: </span> 
						<input type="text" name="highlightColorBG" value="<?php echo $highlightColorBG;?>" >
					</li>
					<li>
						<span class="settingsBuffer" > Font: </span> 
						<input type="text" name="highlightColorFont" value="<?php echo $highlightColorFont;?>" >
					</li>
				</ul>
			</div>
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
		<span style="font-size: 75%;">
			<?php echo generateImage(
				$arrayOfImages["info"],
				array(
					"style"			=>	"margin-bottom: -4px;",
					"height"		=>	"20px",
					"srcModifier"	=>	"../"
				)
			); ?>
			<i>When filtering by content, only show the line (or some sorrounding lines) containing the search content</i>
		</span>
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
								<?php for ($i=0; $i < 10; $i++)
								{
									echo "<option ";
									if($filterContentLinePadding == $i)
									{
										echo " selected ";
									}
									echo " value=".$i.">".$i."</option>";
								}?>
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