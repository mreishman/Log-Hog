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
	<li id="themeSubMenuColorScheme" onclick="toggleThemeColorScheme();">
		Color Scheme
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
	<?php if($samePageSettings === "true"): 

		$customConfigSections = array(
			"multiLogLogLayout"	=> array(
				"id"	=> "settingsInitialLoadLayoutVars",
				"name"	=> "Multi-Log Layout",
				"menu"								=> 	array(
					"groups"							=>	array(
						"main"
					),
					"id"								=>	"settingsMainLogLayout",
					"display"							=>	($enableMultiLog === "true")
				)
			),
			"advancedActions"	=> array(
				"id"	=> "false",
				"name"	=> "Advanced",
				"menu"								=> 	array(
					"groups"							=>	array(
						"advanced"
					),
					"id"								=>	"settingsAdvancedAdvanced",
					"display"							=>	true
				)
			),
			"configStatic"	=> array(
				"id"	=> "devConfig",
				"name"	=> "Config Static",
				"menu"								=> 	array(
					"groups"							=>	array(
						"global"
					),
					"id"								=>	"settingsAdvancedDevConfig",
					"display"							=>	true
				)
			)
		);

		//sort groups
		foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
		{
			$fullScreenMenuGroups[$fsmgKey]["menu_items"] = array();
			foreach([$defaultConfigMoreData, $customConfigSections] as $settingsSectionsArray)
			{
				foreach($settingsSectionsArray as $settingsSectionKey => $settingsSectionsArrayRowData)
				{
					if([$fsmgKey] !== $settingsSectionsArrayRowData["menu"]["groups"])
					{
						continue;
					}
					$fullScreenMenuGroups[$fsmgKey]["menu_items"][$settingsSectionKey] = $settingsSectionsArrayRowData;
				}
			}
			ksort($fullScreenMenuGroups[$fsmgKey]["menu_items"]);
		}

		foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
		{
			echo "<li class=\"menuTitle fullScreenMenuText subMenuTitle\">" . $fsmgData["name"] . "</li>";
			foreach($fsmgData["menu_items"] as $defaultConfigMoreDataRowData)
			{
				$stringToEcho	 = "<li ";
				if(!$defaultConfigMoreDataRowData["menu"]["display"])
				{
					$stringToEcho .= "style = \"display:none;\"";
				}
				$stringToEcho .= " id=\"".
				$defaultConfigMoreDataRowData["menu"]["id"].
				"Menu\" class=\"fullScreenMenuSettingsFormTitle\" onclick=\"toggleSettingSection({id: '".
				$defaultConfigMoreDataRowData["menu"]["id"].
				"',formId: '".
				$defaultConfigMoreDataRowData["id"].
				"'});\" >".
				$defaultConfigMoreDataRowData["name"].
				"</li>";
				echo $stringToEcho;
			}
		} //foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData) ?>
	<?php else: ?>
		<li onclick="window.location.href = './settings/main.php';" >
			Main <?php echo $externalLinkImage; ?>
		</li>
		<li onclick="window.location.href = './settings/advanced.php';" >
			Advanced <?php echo $externalLinkImage; ?>
		</li>
		<li onclick="window.location.href = './settings/devTools.php';" >
			Global <?php echo $externalLinkImage; ?>
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
	<?php foreach ($defaultConfigMoreData as $currentSection => $configRowData): ?>
		<div id="<?php echo $configRowData["menu"]["id"]; ?>" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
			<?php include('core/php/template/varTemplate.php');	?>
		</div>
	<?php endforeach; ?>
	<div id="settingsMainLogLayout" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
		<?php
		require_once('core/php/template/logLayout.php');
		?>
	</div>
	<div id="settingsAdvancedAdvanced" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
		<?php
			$settingsUrlModifier = "";
			$otherSettingsUrlModifier = "settings/";
			include('core/php/template/advancedActions.php');
		?>
	</div>
	<div id="settingsAdvancedDevConfig" class="fullScreenMenuSettingsFormDiv" style="display: none;">
		<?php
			require_once("core/php/template/devConfigSettings.php");
		?>
	</div>
</div>