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
</ul>
<div id="mainContentFullScreenMenu">
	<div class="settingsHeader" style="position: fixed;width: 100%;z-index: 10;top: 0; margin: 0; border-bottom: 1px solid white; display: none;top: 46px;" id="fixedPositionMiniMenu" >
	</div>
	<div id="fullScreenMenuChangeLog" style="display: none;" >
		<?php require_once("changelog.php"); ?>
	</div>
	<div id="fullScreenMenuWhatsNew" style="display: none;" >
		<?php
		$imageDirModifierAbout = "";
		require_once('whatsNew.php');
		?>
	</div>
	<div id="fullScreenMenuAbout" >
		<?php require_once('about.php'); ?>
	</div>
	<div id="fullScreenMenuUpdate" style="display: none;">
		<?php require_once('update.php'); ?>
	</div>
	<div id="fullScreenMenuIFrame" style="display: none;">
		<iframe style="border: 0;" id="iframeFullScreen" src="core/html/iframe.html"></iframe>
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
		<?php require_once('core/php/template/themeMain.php'); ?>
	</div>
	<div id="fullScreenMenuColorScheme" style="display: none;">
		<?php require_once('core/php/template/folderGroupColor.php'); ?>
	</div>
	<div id="fullScreenMenuThemeGeneralStyle" style="display: none;">
		<?php require_once('core/php/template/generalThemeOptions.php'); ?>
	</div>
</div>