<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Main Settings 
<div class="settingsHeaderButtons">
	<a onclick="resetSettingsMainVar();" id="resetChangesMainSettingsHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
	<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Slice Size:</span>  <input type="text" name="sliceSize" value="<?php echo $sliceSize;?>" > Lines
	</li>
	<li>
		<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" >
		<select name="pollingRateType">
				<option <?php if($pollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($pollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
		</select>
	</li>
	<li>
		<span class="settingsBuffer" > Background Poll Rate: </span>  <input type="text" name="backgroundPollingRate" value="<?php echo $backgroundPollingRate;?>" >
		<select name="backgroundPollingRateType">
				<option <?php if($backgroundPollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($backgroundPollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
		</select>
		<br>
		<i style="font-size: 75%;" >Only if Pause On Not Focus is set to True</i>
	</li>
	<li>
		<span class="settingsBuffer" > Log trim:  </span>
		<select id="logTrimOn" name="logTrimOn">
			<option <?php if($logTrimOn == 'true'){echo "selected";} ?> value="true">True</option>
			<option <?php if($logTrimOn == 'false'){echo "selected";} ?> value="false">False</option>
		</select>

		<div id="settingsLogTrimVars" <?php if($logTrimOn == 'false'){echo "style='display: none;'";}?> >

		<div class="settingsHeader">
			Log Trim Settings
			</div>
			<div class="settingsDiv" >
			<ul id="settingsUl">
			
				<li>
				<span class="settingsBuffer" > Max 

				<select id="logTrimTypeToggle" name="logTrimType">
							<option <?php if($logTrimType == 'lines'){echo "selected";} ?> value="lines">Line Count</option>
							<option <?php if($logTrimType == 'size'){echo "selected";} ?> value="size">File Size</option>
					</select>
				


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
					<select name="logTrimMacBSD">
							<option <?php if($logTrimMacBSD == 'true'){echo "selected";} ?> value="true">True</option>
							<option <?php if($logTrimMacBSD == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>

				<li id="LiForlogTrimSize" <?php if($logTrimType != 'size'){echo "style='display:none;'";} ?> >
					<span class="settingsBuffer" > Size is measured in: </span>  
					<select name="TrimSize">
							<option <?php if($TrimSize == 'KB'){echo "selected";} ?> value="KB">KB</option>
							<option <?php if($TrimSize == 'K'){echo "selected";} ?> value="K">K</option>
							<option <?php if($TrimSize == 'MB'){echo "selected";} ?> value="MB">MB</option>
							<option <?php if($TrimSize == 'M'){echo "selected";} ?> value="M">M</option>
					</select>
					<br>
					<span style="font-size: 75%;">*<i>This will increase poll times by 2x to 4x</i></span>
				</li>

			</ul>
			</div>
		</div>


	</li>
	<li>
		<span class="settingsBuffer" > Pause Poll By Default:  </span> 
			<select name="pausePoll">
					<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
	</li>
	<li>
		<span class="settingsBuffer" > Pause On Not Focus: </span> 
			<select name="pauseOnNotFocus">
					<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
	</li>
	<li>
		<span class="settingsBuffer" > Auto Check Update: </span> 
			<select id="settingsSelect" name="autoCheckUpdate">
					<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
			</select>

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
					<select id="updateNoticeMeter" name="updateNoticeMeter">
  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
					</select>
				</li>

			</ul>
			</div>
		</div>

	</li>
	<li>
		<span class="settingsBuffer" > Popup Warnings: </span> 
			<select id="popupSelect"  name="popupWarnings">
					<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
					<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
					<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
			</select>
		<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

		<div class="settingsHeader">
			Popup Settings
			</div>
			<div class="settingsDiv" >
			<ul id="settingsUl">
			<?php foreach ($popupSettingsArray as $key => $value):?>
				<li>
				<span class="settingsBuffer" > <?php echo $key;?>: </span> 
					<select name="<?php echo $key;?>">
  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
					</select>
				</li>
			<?php endforeach;?>
			</ul>
			</div>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Flash title on log update: </span> 
			<select name="flashTitleUpdateLog">
					<option <?php if($flashTitleUpdateLog == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($flashTitleUpdateLog == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
	</li>
	<li>
		<span class="settingsBuffer" > Right Click Menu Enabled: </span> 
			<select name="rightClickMenuEnable">
					<option <?php if($rightClickMenuEnable == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($rightClickMenuEnable == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
	</li>
	<li>
		<span class="settingsBuffer" > Enable Themes: </span> 
			<select name="themesEnabled">
					<option <?php if($themesEnabled == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($themesEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
	</li>
</ul>
</div>
</form>