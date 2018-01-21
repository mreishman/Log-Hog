<form id="settingsLogVars" action="../core/php/settingsSave.php" method="post">
	<div class="settingsHeader">
	Log Settings
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsLogVars");
		if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsLogVars');" >Save Changes</a>
		<?php endif; ?>
	</div>
	</div>
	<div class="settingsDiv" >
	<ul id="settingsUl">
		<li>
			<span class="settingsBuffer" >Number of lines to display:</span>  <input type="text" name="sliceSize" value="<?php echo $sliceSize;?>" >
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
			<span class="settingsBuffer" > Flash title on log update: </span>
			<div class="selectDiv">
				<select name="flashTitleUpdateLog">
					<option <?php if($flashTitleUpdateLog == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($flashTitleUpdateLog == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
			</div>
		</li>
		<li>
			<span class="settingsBuffer" > Scroll Log on update: </span>
			<div class="selectDiv">
				<select name="scrollOnUpdate">
					<option <?php if($scrollOnUpdate == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($scrollOnUpdate == 'false'){echo "selected";} ?> value="false">False</option>
				</select>
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
						<input type="text" name="logSizeLimit" value="<?php echo $logSizeLimit;?>" > 
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
					 	<input type="text" name="buffer" value="<?php echo $buffer;?>" > 
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