<?php require_once('indexHeaderFullScreen.php'); ?>
<ul id="mainFullScreenMenu" class="settingsUl settingsUlFS fullScreenMenuUL">
	<?php require_once('fullScreenMenuSidebar.php'); ?>
</ul>

<ul id="aboutSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub">
	<li class="menuTitle" style="text-align: center;" >
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
	<li class="menuTitle" style="text-align: center;" >
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
	<li class="menuTitle" style="text-align: center;" >
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
	<li class="menuTitle" style="text-align: center;" >
	</li>
	<li class="subMenuActionsColorScheme subMenuToggle" style="display: none;" onclick="addRowForFolderColorOptions();" >
		Add Row
	</li>
</ul>
<ul id="watchListSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
	<li class="menuTitle" style="text-align: center;" >
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
	<li class="menuTitle" style="text-align: center;">
		Settings
	</li>
	<li class="menuTitle fullScreenMenuText subMenuTitle">
		Main
	</li>
	<li onclick="window.location.href = './settings/main.php#settingsLogVars';" >
		Logs <?php echo $externalLinkImage; ?>
	</li>
	<?php if($advancedLogFormatEnabled === "true"): ?>
		<li onclick="window.location.href = './settings/main.php#settingsLogFormatVars';" >
			Log Format <?php echo $externalLinkImage; ?>
		</li>
	<?php endif; ?>
	<li onclick="window.location.href = './settings/main.php#settingsPollVars';" >
		Poll <?php echo $externalLinkImage; ?>
	</li>
	<?php if($filterEnabled === "true"): ?>
		<li onclick="window.location.href = './settings/main.php#settingsFilterVars';" >
			Filter <?php echo $externalLinkImage; ?>
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
	<div class="settingsHeader addBorderBottom" style="position: fixed;width: 100%;z-index: 10;top: 0; margin: 0; display: none;top: 46px;" id="fixedPositionMiniMenu" >
	</div>
	<div id="fullScreenMenuChangeLog" style="display: none;" >
		<?php require_once("changelog.php"); ?>
	</div>
	<div id="fullScreenMenuWhatsNew" style="display: none;" >
		<?php require_once('whatsNew.php'); ?>
	</div>
	<div id="fullScreenMenuAbout" >
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
		<iframe style="border: 0;" id="iframeFullScreen" src=""></iframe>
	</div>
	<div id="fullScreenMenuWatchList" style="display: none;">
		<?php
		$imageUrlModifier = "";
		require_once('core/php/settingsMainWatchFunctions.php');
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
		<div id="notificationHolder" class="fullScreenMenuLeftSidebar" style="display: inline-block; height: 100%; overflow-y: auto;" ></div>
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
</div>