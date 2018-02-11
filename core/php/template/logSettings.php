<form id="settingsLogVars">
	<div class="settingsHeader">
	Log Settings
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsLogVars");?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsLogVars');" >Save Changes</a>
	</div>
	</div>
	<div class="settingsDiv" >
	<ul id="settingsUl">
		<li>
			<span class="settingsBuffer" >Number of lines to display:</span>  <input type="number" pattern="[0-9]*" name="sliceSize" value="<?php echo $sliceSize;?>" >
		</li>
		<li>
			<span class="settingsBuffer" > Flash title on log update: </span>
			<div class="selectDiv">
				<select name="flashTitleUpdateLog">
					<option <?php if($flashTitleUpdateLog == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($flashTitleUpdateLog == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
			</div>
		</li>
		<li>
			<span class="settingsBuffer" > Auto show log on update: </span>
			<div class="selectDiv">
				<select name="autoMoveUpdateLog">
					<option <?php if($autoMoveUpdateLog == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($autoMoveUpdateLog == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
			</div>
		</li>
		<li>
			<span class="settingsBuffer" > Scroll Log on update: </span>
			<div class="selectDiv">
				<select id="scrollOnUpdate" name="scrollOnUpdate">
					<option <?php if($scrollOnUpdate == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($scrollOnUpdate == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
			</div>
			<div id="scrollLogOnUpdateSettings" style=" <?php if($scrollOnUpdate == 'false'){ echo 'display: none;'; }?> " >
			<div class="settingsHeader">
			Scroll Log On Update Settings
			</div>
			<div class="settingsDiv" >
				<ul id="settingsUl">
					<li>
						<span class="settingsBuffer" > Scroll even if Scrolled: </span>
						<div class="selectDiv"> 
							<select name="scrollEvenIfScrolled">
								<option <?php if($scrollEvenIfScrolled == 'true'){echo "selected";} ?> value="true">True</option>
								<option <?php if($scrollEvenIfScrolled == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</div>
					</li>
				</ul>
			</div>
		</div>
		</li>
		<li>
		<span class="settingsBuffer" > Temp Highlight New Lines: </span>
		<div class="selectDiv">
			<select id="highlightNew" name="highlightNew">
				<option <?php if($highlightNew == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($highlightNew == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
		<div id="highlightNewSettings" style=" <?php if($highlightNew == 'false'){ echo 'display: none;'; }?> " >
			<div class="settingsHeader">
			Highlight New Lines Settings
			</div>
			<div class="settingsDiv" >
				<ul id="settingsUl">
					<li>
						<span class="settingsBuffer" > Background: </span> 
						<input type="text" name="highlightNewColorBG" value="<?php echo $highlightNewColorBG;?>" >
					</li>
					<li>
						<span class="settingsBuffer" > Font: </span> 
						<input type="text" name="highlightNewColorFont" value="<?php echo $highlightNewColorFont;?>" >
					</li>
				</ul>
			</div>
		</div>
	</li>
		<li>
			<span class="settingsBuffer" > Log trim:  </span>
			<div class="selectDiv">
				<select id="logTrimOn" name="logTrimOn">
					<option <?php if($logTrimOn == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($logTrimOn == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
			</div>
			<div id="settingsLogTrimVars" <?php if($logTrimOn == 'false'){echo "style='display: none;'";}?> >

			<div class="settingsHeader">
				Log Trim Settings
			</div>
			<div class="settingsDiv" >
				<ul id="settingsUl">
				
					<li>
					<span class="settingsBuffer" > Max 
					<div class="selectDiv">
						<select id="logTrimTypeToggle" name="logTrimType">
							<option <?php if($logTrimType == 'lines'){echo "selected";} ?> value="lines">Line Count</option>
							<option <?php if($logTrimType == 'size'){echo "selected";} ?> value="size">File Size</option>
						</select>
					</div>


					: </span> 
						<input type="number" pattern="[0-9]*" name="logSizeLimit" value="<?php echo $logSizeLimit;?>" > 
						<span id="logTrimTypeText" >
							<?php if($logTrimType == 'lines')
							{
								echo "Lines";
							}
							elseif($logTrimType == 'size')
							{
								echo $TrimSize;
							}
							?>
						</span>
					</li>
					<li>
					<span class="settingsBuffer" > Buffer Size: </span>
					 	<input type="number" pattern="[0-9]*" name="buffer" value="<?php echo $buffer;?>" > 
					</li>
					<li id="LiForlogTrimMacBSD">
						<span class="settingsBuffer" > Use Mac/Free BSD Command: </span>
						<div class="selectDiv">
							<select name="logTrimMacBSD">
									<option <?php if($logTrimMacBSD == 'true'){echo "selected";} ?> value="true">True</option>
									<option <?php if($logTrimMacBSD == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</div>
					</li>

					<li id="LiForlogTrimSize" <?php if($logTrimType != 'size'){echo "style='display:none;'";} ?> >
						<span class="settingsBuffer" > Size is measured in: </span>
						<div class="selectDiv">
							<select id="TrimSize" name="TrimSize">
									<option <?php if($TrimSize == 'KB'){echo "selected";} ?> value="KB">KB</option>
									<option <?php if($TrimSize == 'K'){echo "selected";} ?> value="K">K</option>
									<option <?php if($TrimSize == 'MB'){echo "selected";} ?> value="MB">MB</option>
									<option <?php if($TrimSize == 'M'){echo "selected";} ?> value="M">M</option>
							</select>
						</div>
						<br>
						<span style="font-size: 75%;">*<i>This will increase poll times by 2x to 4x</i></span>
					</li>

				</ul>
				</div>
			</div>
		</li>
	</ul>
	</div>
</form>