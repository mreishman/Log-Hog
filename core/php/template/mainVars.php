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
		<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" >
		<div class="selectDiv">
			<select name="pollingRateType">
				<option <?php if($pollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($pollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Background Poll Rate: </span>  <input type="text" name="backgroundPollingRate" value="<?php echo $backgroundPollingRate;?>" >
		<div class="selectDiv">
			<select name="backgroundPollingRateType">
				<option <?php if($backgroundPollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($backgroundPollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>	
		<br>
		<i style="font-size: 75%;" >Only if Pause On Not Focus is set to False</i>
	</li>
		<div class="settingsHeader">
		Log Settings
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
									<select name="TrimSize">
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
	<li>
		<span class="settingsBuffer" > Pause Poll By Default:  </span>
		<div class="selectDiv">
			<select name="pausePoll">
				<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Pause On Not Focus: </span>
		<div class="selectDiv">
			<select name="pauseOnNotFocus">
				<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
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
	<li>
		<span class="settingsBuffer" > Right Click Menu Enabled: </span>
		<div class="selectDiv">
			<select name="rightClickMenuEnable">
				<option <?php if($rightClickMenuEnable == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($rightClickMenuEnable == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Enable Themes: </span>
		<div class="selectDiv">
			<select name="themesEnabled">
				<option <?php if($themesEnabled == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($themesEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>