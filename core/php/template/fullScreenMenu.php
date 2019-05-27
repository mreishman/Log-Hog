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
	<li id="settingsMainLogsMenu" onclick="toggleSettingsMainLogs();" >
		Logs
	</li>
	<?php if($advancedLogFormatEnabled === "true"): ?>
		<li id="settingsMainLogFormatMenu" onclick="toggleSettingsMainLogFormat();" >
			Log Format
		</li>
	<?php endif; ?>
	<li id="settingsMainPollMenu" onclick="toggleSettingsMainPoll();" >
		Poll
	</li>
	<?php if($filterEnabled === "true"): ?>
		<li id="settingsMainFilterMenu" onclick="togleSettingsMainFilter();" >
			Filter
		</li>
	<?php endif; ?>
	<li onclick="window.location.href = './settings/main.php#archiveConfig';" >
		Archive <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/main.php#settingsNotificationVars';" >
		Notifications <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/main.php#settingsMenuVars';" >
		Menu <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/main.php#settingsWatchlistVars';" >
		Watchlist <?php echo $externalLinkImage; ?>
	</li>
	<?php if($oneLogEnable === "true"): ?>
		<li onclick="window.location.href = './settings/main.php#settingsOneLogVars';" >
			OneLog <?php echo $externalLinkImage; ?>
		</li>
	<?php endif; ?>
	<?php if($enableMultiLog === "true"): ?>
		<li onclick="window.location.href = './settings/main.php#settingsMultiLogVars';" >
			Multi-Log <?php echo $externalLinkImage; ?>
		</li>
		<li onclick="window.location.href = './settings/main.php#settingsInitialLoadLayoutVars';" >
			Log Layout <?php echo $externalLinkImage; ?>
		</li>
	<?php endif; ?>
	<li onclick="window.location.href = './settings/main.php#settingsMainVars';" >
		Other <?php echo $externalLinkImage; ?>
	</li>
	<li class="menuTitle fullScreenMenuText subMenuTitle">
		Advanced
	</li>
	<li onclick="window.location.href = './settings/advanced.php#advancedConfig';" >
		Config <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/advanced.php#modules';" >
		Modules <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/advanced.php#loggingDisplay';" >
		Logs <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/advanced.php#locationOtherApps';" >
		Locations <?php echo $externalLinkImage; ?>
	</li>
	<li onclick="window.location.href = './settings/advanced.php#advancedConfig';" >
		Advanced <?php echo $externalLinkImage; ?>
	</li>
	<?php if($developmentTabEnabled === "true"): ?>
		<li onclick="window.location.href = './settings/devTools.php';" >
			Dev <?php echo $externalLinkImage; ?>
		</li>
	<?php endif; ?>
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
	</div>
	<div id="settinsgMainNotifications" style="display: none;" >
	</div>
	<div id="settingsMainMenu" style="display: none;" >
	</div>
	<div id="settingsMainWatchlist" style="display: none;" >
	</div>
	<div id="settingsMainOneLog" style="display: none;" >
	</div>
	<div id="settingsMainMultiLog" style="display: none;" >
	</div>
	<div id="settingsMainLogLayout" style="display: none;" >
	</div>
	<div id="settingsMainOther" style="display: none;" >
	</div>
	<div id="settingsAdvancedConfig" style="display: none;" >
	</div>
	<div id="settingsAdvancedModules" style="display: none;" >
	</div>
	<div id="settingsAdvancedLogs" style="display: none;" >
	</div>
	<div id="settingsAdvancedLocations" style="display: none;" >
	</div>
	<div id="settingsAdvancedAdvanced" style="display: none;" >
	</div>
	<div id="settingsAdvancedDev" style="display: none;" >
	</div>
</div>