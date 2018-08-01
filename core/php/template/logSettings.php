<form id="settingsLogVars">
	<div class="settingsHeader">
	Log Settings Part 2
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsLogVars");?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsLogVars');" >Save Changes</a>
	</div>
	</div>
	<div class="settingsDiv" >
	<ul class="settingsUl">
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
				<ul class="settingsUl">
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
						<span style="font-size: 75%;">
							<?php echo generateImage(
								$arrayOfImages["info"],
								array(
									"style"			=>	"margin-bottom: -4px;",
									"height"		=>	"20px",
									"srcModifier"	=>	"../"
								)
							); ?>
							<i>This will increase poll times by 2x to 4x</i>
						</span>
					</li>
				</ul>
				</div>
			</div>
		</li>
		<li>
			<span class="settingsBuffer" > First Log Select: </span>
			<span id="logSelectedFirstLoad" >
				<?php if ($logSelectedFirstLoad === ""):?>
					No Log Selected
				<?php else: ?>
					<?php echo $logSelectedFirstLoad; ?>
				<?php endif; ?>
			</span>
			<span onclick="selectLogPopup('logSelectedFirstLoad');" class="link">Select Log</span>
			<?php if ($logSelectedFirstLoad === ""):?>
				<input type="hidden" name="logSelectedFirstLoad" value="" >
			<?php else: ?>
				<input type="hidden" name="logSelectedFirstLoad" value="<?php echo $logSelectedFirstLoad; ?>" >
			<?php endif; ?>
		</li>
		<li>
			<span style="font-size: 75%;">
				<?php echo generateImage(
					$arrayOfImages["info"],
					array(
						"style"			=>	"margin-bottom: -4px;",
						"height"		=>	"20px",
						"srcModifier"	=>	"../"
					)
				); ?>
				<i>If Multi-Log is enabled, and a variable is set for intial load logs there, this var will be overridden</i>
			</span>
		</li>
	</ul>
	</div>
</form>