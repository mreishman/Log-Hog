<form id="devBranch">
	<div class="settingsHeader">
		Branch Settings
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("devBranch"); ?>
			<a class="linkSmall devBranchSaveButton" onclick="saveAndVerifyMain('devBranch');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<span class="settingsBuffer" >  Enable Development Branch: </span>
				<div class="selectDiv">
					<select name="enableDevBranchDownload">
							<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
							<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer" >  Base URL:  </span> <input type="text" class="inputWidth"  name="baseUrlUpdate" value="<?php echo $baseUrlUpdate;?>" >
			</li>
			<li>
				<span style="font-size: 75%;">
					<?php echo $core->generateImage(
						$arrayOfImages["info"],
						array(
							"style"			=>	"margin-bottom: -4px;",
							"height"		=>	"20px",
							"srcModifier"	=>	$settingsUrlModifier
						)
					); ?>
					<i>
						Default: https://github.com/mreishman/Log-Hog/archive/
					</i>
				</span>
			</li>
			<li>
				<span class="settingsBuffer" > Config Version: [Refresh to run upgrade scripts]  </span> <input type="number" pattern="[0-9]*" class="inputWidth" name="configVersion" value="<?php echo $configVersion;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Layout Version: [Refresh to run upgrade scripts]  </span> <input type="number" pattern="[0-9]*" class="inputWidth"  name="layoutVersion" value="<?php echo $layoutVersion;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Theme Version: [Refresh to run upgrade scripts]  </span> <input type="number" pattern="[0-9]*" class="inputWidth"  name="themeVersion" value="<?php echo $themeVersion;?>" >
			</li>
		</ul>

	</div>
</form>