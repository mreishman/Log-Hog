<?php require_once('indexHeaderFullScreen.php'); ?>
<ul id="mainFullScreenMenu" class="settingsUl settingsUlFS fullScreenMenuUL">
	<?php require_once('fullScreenMenuSidebar.php'); ?>
</ul>

<ul id="aboutSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle">
		About
	</li>
	<li id="aboutSubMenuAbout" onclick="toggleAboutLogHog();" class="selected">
		About Log-Hog
	</li>
	<li id="aboutSubMenuWhatsNew" onclick="toggleWhatsNew();">
		What's New
	</li>
	<li id="aboutSubMenuChangelog" onclick="toggleChangeLog();">
		Changelog
	</li>
</ul>
<ul id="historySubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle">
		History
	</li>
	<li id="tempSaveHistory" onclick="toggleTmpSaveHistory();">
		Temp Saves
	</li>
	<li id="archiveHistory" onclick="toggleArchiveHistory();">
		Archived
	</li>
</ul>
<ul id="themeSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle">
		Themes
	</li>
	<li id="themeSubMenuMainThemes" onclick="toggleMainThemes();" class="selected">
		Main Themes
	</li>
	<li id="themeSubMenuGeneralStyle" onclick="toggleGeneralThemeStyle();">
		General Styling
	</li>
	<li id="themeSubMenuColorScheme" onclick="toggleThemeColorScheme();">
		Color Scheme
	</li>
	<li class="menuTitle">
	</li>
	<li class="subMenuActionsColorScheme subMenuToggle" style="display: none;" onclick="addRowForFolderColorOptions();" >
		Add Row
	</li>
</ul>
<ul id="watchListSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle">
		Watchlist
	</li>
	<li onclick="addFile();" >
		Add File
	</li>
	<li onclick="addFolder();" >
		Add Folder
	</li>
	<li onclick="addOther();" >
		Add Other
	</li>
	<li id="condensedLink" onclick="toggleCondensed(true);" >
	<?php if($logShowMoreOptions === "false"): ?>
		Show More Options</li>
		<style type="text/css">
			.condensed
			{
				display: none;
			}
		</style>
	<?php else: ?>
		Show Condensed Options</li>
	<?php endif; ?>
</ul>
<ul id="settingsSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle">
		Settings
	</li>
	<li class="menuTitle fullScreenMenuText subMenuTitle">
		Main
	</li>
	<li id="settingsMainLogsMenu" onclick="toggleSettingSection({id: 'settingsMainLogs',formId: 'settingsLogVars'});" >
		Logs <?php echo $needRefresh; ?>
	</li>
	<li <?php if($advancedLogFormatEnabled !== "true"){ echo "style = \"display:none;\"";} ?> id="settingsMainLogFormatMenu" onclick="toggleSettingSection({id: 'settingsMainLogFormat',formId: 'settingsLogFormatVars'});" >
		Log Format
	</li>
	<li id="settingsMainPollMenu" onclick="toggleSettingSection({id: 'settingsMainPoll',formId: 'settingsPollVars'});" >
		Poll <?php echo $needRefresh; ?>
	</li>
	<li <?php if($filterEnabled !== "true"){ echo "style = \"display:none;\"";} ?> id="settingsMainFilterMenu" onclick="toggleSettingSection({id: 'settingsMainFilter',formId: 'settingsFilterVars'});" >
		Filter <?php echo $needRefresh; ?>
	</li>
	<li id="settingsMainArchiveMenu" onclick="toggleSettingSection({id: 'settingsMainArchive',formId: 'archiveConfig'});" >
		Archive
	</li>
	<li id="settingsMainNotificationsMenu" onclick="toggleSettingSection({id: 'settingsMainNotifications',formId: 'settingsNotificationVars'});" >
		Notifications <?php echo $needRefresh; ?>
	</li>
	<li id="settingsMainMenuMenu" onclick="toggleSettingSection({id: 'settingsMainMenu',formId: 'settingsMenuVars'});" >
		Menu <?php echo $needRefresh; ?>
	</li>
	<li id="settingsMainWatchlistMenu" onclick="toggleSettingSection({id: 'settingsMainWatchlist',formId: 'settingsWatchlistVars'});" >
		Watchlist
	</li>
	<li <?php if($oneLogEnable !== "true"){ echo "style = \"display:none;\"";} ?> id="settingsMainOneLogMenu" onclick="toggleSettingSection({id: 'settingsMainOneLog',formId: 'settingsOneLogVars'});" >
		OneLog
	</li>
	<li <?php if($enableMultiLog !== "true"){ echo "style = \"display:none;\"";} ?> id="settingsMainMultiLogMenu" onclick="toggleSettingSection({id: 'settingsMainMultiLog',formId: 'settingsMultiLogVars'});" >
		Multi-Log
	</li>
	<li <?php if($enableMultiLog !== "true"){ echo "style = \"display:none;\"";} ?> id="settingsMainLogLayoutMenu" onclick="toggleSettingSection({id: 'settingsMainLogLayout',formId: 'settingsInitialLoadLayoutVars'});" >
		Log Layout
	</li>
	<li id="settingsMainOtherMenu" onclick="toggleSettingSection({id: 'settingsMainOther',formId: 'settingsMainVars'});" >
		Other
	</li>
	<li class="menuTitle fullScreenMenuText subMenuTitle">
		Advanced
	</li>
	<li id="settingsAdvancedConfigMenu" onclick="toggleSettingSection({id: 'settingsAdvancedConfig',formId: 'advancedConfig'});" >
		Config
	</li>
	<li id="settingsAdvancedModulesMenu" onclick="toggleSettingSection({id: 'settingsAdvancedModules',formId: 'modules'});" >
		Modules <?php echo $needRefresh; ?>
	</li>
	<li id="settingsAdvancedLogsMenu" onclick="toggleSettingSection({id: 'settingsAdvancedLogs',formId: 'loggingDisplay'});" >
		Logs
	</li>
	<li id="settingsAdvancedLocationsMenu" onclick="toggleSettingSection({id: 'settingsAdvancedLocations',formId: 'locationOtherApps'});" >
		Locations <?php echo $needRefresh; ?>
	</li>
	<li id="settingsAdvancedAdvancedMenu" onclick="toggleSettingSection({id: 'settingsAdvancedAdvanced',formId: 'false'});" >
		Advanced
	</li>
	<li <?php if($developmentTabEnabled !== "true"){ echo "style = \"display:none;\"";} ?> class="menuTitle fullScreenMenuText subMenuTitle">
		Dev
	</li>
	<li id="settingsAdvancedDevBranchMenu" <?php if($developmentTabEnabled !== "true"){ echo "style = \"display:none;\"";} ?> onclick="toggleSettingSection({id: 'settingsAdvancedDevBranch', formId: 'devBranch'});" >
		Branch
	</li>
	<li id="settingsAdvancedDevConfigMenu" <?php if($developmentTabEnabled !== "true"){ echo "style = \"display:none;\"";} ?> onclick="toggleSettingSection({id: 'settingsAdvancedDevConfig', formId: 'devConfig'});" >
		Config
	</li>
	<li class="menuTitle fullScreenMenuText">
		<?php echo $needRefresh; ?> = refresh required
	</li>
</ul>
<div id="mainContentFullScreenMenu">
	<div class="settingsHeader addBorderBottom" style="display: none;" id="fixedPositionMiniMenu" >
	</div>
	<div id="fullScreenMenuChangeLog" style="display: none;" >
		<?php require_once("changelog.php"); ?>
	</div>
	<div id="fullScreenMenuWhatsNew" style="display: none;" >
		<?php require_once('whatsNew.php'); ?>
	</div>
	<div id="fullScreenMenuAbout" style="display: none;">
		<?php require_once('about.php'); ?>
	</div>
	<div id="fullScreenMenuHistory" style="display: none;">
		<span id="historyHolder"></span>
	</div>
	<div id="fullScreenMenuArchive" style="display: none;">
		<span id="archiveHolder"></span>
	</div>
	<div id="fullScreenMenuUpdate" style="display: none;">
		<?php require_once('update.php'); ?>
	</div>
	<div id="fullScreenMenuIFrame" style="display: none;">
		<iframe id="iframeFullScreen" src=""></iframe>
	</div>
	<div id="fullScreenMenuWatchList" style="display: none;">
		<?php
		$imageUrlModifier = "";
		require_once('settingsMainWatch.php');
		?>
	</div>
	<div id="fullScreenMenuAddons" style="display: none;" >
		<div class="settingsHeader">
			Addons
		</div>
		<div class="settingsDiv" >
			<?php require_once("innerAddon.php"); ?>
		</div>
	</div>
	<div id="fullScreenMenuTheme" style="display: none;">
		<script type="text/javascript">
			var themeDirMod = "";
		</script>
		<?php
		$themeDirMod = "";
		require_once('core/php/template/themeMain.php');
		?>
	</div>
	<div id="fullScreenMenuColorScheme" style="display: none;">
		<?php require_once('core/php/template/folderGroupColor.php'); ?>
	</div>
	<div id="fullScreenMenuThemeGeneralStyle" style="display: none;">
		<?php
		$currentSection = "generalThemeOptions";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="notifications" style="display: none;" >
		<div id="notificationHolder"></div>
	</div>
	<div id="notificationsEmpty" style="display: none;" >
		<table width="100%" style="height: 100%;">
			<tr>
				<th valign="center" >
					<div class="noNotificationsNotification addBorder" >
						You have no new notifications!
					</div>
				</th>
			</tr>
		</table>
	</div>
	<div id="settingsMainLogs" style="display: none;" >
		<?php
		$currentSection = "logVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainLogFormat" style="display: none;" >
		<?php
		$currentSection = "logFormatVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainPoll" style="display: none;" >
		<?php
		$currentSection = "pollVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainFilter" style="display: none;" >
		<?php
		$currentSection = "filterVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainArchive" style="display: none;" >
		<?php
		$currentSection = "archive";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainNotifications" style="display: none;" >
		<?php
		$currentSection = "notificationVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainMenu" style="display: none;" >
		<?php
		$currentSection = "menuVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainWatchlist" style="display: none;" >
		<?php
		$currentSection = "watchlistVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainOneLog" style="display: none;" >
		<?php
		$currentSection = "oneLogVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainMultiLog" style="display: none;" >
		<?php
		$currentSection = "multiLogVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsMainLogLayout" style="display: none;" >
		<?php
		require_once('core/php/template/logLayout.php');
		?>
	</div>
	<div id="settingsMainOther" style="display: none;" >
		<?php
		$currentSection = "otherVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsAdvancedConfig" style="display: none;" >
		<?php
		$currentSection = "config";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsAdvancedModules" style="display: none;" >
		<?php
		$currentSection = "modules";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsAdvancedLogs" style="display: none;" >
		<?php
		$currentSection = "loggingVars";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsAdvancedLocations" style="display: none;" >
		<?php
		$currentSection = "fileLocations";
		include('core/php/template/varTemplate.php');
		?>
	</div>
	<div id="settingsAdvancedAdvanced" style="display: none;" >
		<?php
			$settingsUrlModifier = "";
			$otherSettingsUrlModifier = "settings/";
			include('core/php/template/advancedActions.php');
		?>
	</div>
	<div id="settingsAdvancedDevBranch" style="display: none;" >
		<?php
			$settingsUrlModifier = "";
			require_once("core/php/template/devBranch.php");
		?>
	</div>
	<div id="settingsAdvancedDevConfig" style="display: none;">
		<?php
			require_once("core/php/template/devConfigSettings.php");
		?>
	</div>
</div>