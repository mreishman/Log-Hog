<span id="moreAdvancedSpan">
	<div id="moreAdvanced" class="settingsHeader">
		Advanced
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<a style="text-decoration: none;" href="<?php echo $settingsUrlModifier; ?>setup/step1.php" class="link">Re-do Setup</a>
			</li>
			<li>
				<a onclick="revertPopup();" class="link">Revert Version</a>
			</li>
			<li>
				<a onclick="resetUpdateNotification();" class="link">Reset Update Notification</a>
			</li>
			<li>
				<a class="link" href="<?php echo $otherSettingsUrlModifier; ?>editFiles.php" >View Files</a>
			</li>
			<li>
				<a onclick="showConfigPopup();" class="link">View restore options for config</a>
			</li>
			<li>
				<span id="showConfigClearButton">
					<a onclick="clearBackupFiles();" class="link">Clear Backup Config Files</a>
				</span>
			</li>
			<li>
				<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
			</li>
		</ul>
	</div>
</span>
<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post"> <!-- Reset update notification form -->
	<input type="hidden" name="newestVersion" value="<?php echo $configStatic['version'];?>" >
</form>
<script type="text/javascript">
	var htmlRestoreOptions = "<?php echo $settings->generateRestoreList($configStatic); ?>";
</script>