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
	<?php 
	$settingsRightClickMenu = [];
	$idArray = []; 
	foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
	{
		if($samePageSettings === "true")
		{
			echo "<li class=\"menuTitle fullScreenMenuText subMenuTitle\" id=\"subMenuTitle-" . $fsmgKey . "\">" . $fsmgData["name"] . "</li>";
			foreach($fsmgData["menu_items"] as $defaultConfigMoreDataRowData)
			{
				$idArray[] = $defaultConfigMoreDataRowData["id"];
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
				$defaultConfigMoreDataRowData["menu"]["name"].
				"</li>";
				echo $stringToEcho;
				$settingsRightClickMenu[] = [
					"id"	=> $defaultConfigMoreDataRowData["menu"]["id"] . "Menu",
					"link"	=> "./settings.php?tab=" . $fsmgKey . "&id=" . $defaultConfigMoreDataRowData["menu"]["id"]
				];
			}
		}
		else
		{
			if ($samePageSettingsNewTab === "true")
			{
				echo "<li onclick=\"window.open('./settings.php?tab=" . $fsmgKey . "');\">";
			}
			else
			{
				echo "<li onclick=\"window.location.href ='./settings.php?tab=" . $fsmgKey . "';\">";
			}
			echo $fsmgData["name"]." ".$externalLinkImage.
			"</li>";
		}
	}
	$arrOfPossibleGroups = "";
	if (count($idArray) > 0)
	{
		$arrOfPossibleGroups = '"'.implode('","', $idArray).'"';
	}
	?>
	<script type="text/javascript">
		var listOfMenuRightClick = <?php echo json_encode($settingsRightClickMenu); ?>;
		var arrOfPossibleGroups = [<?php echo $arrOfPossibleGroups; ?>];
	</script>
</ul>
<div id="mainContentFullScreenMenu">
	<div class="settingsHeader addBorderBottom" style="display: none;" id="fixedPositionMiniMenu" >
	</div>
	<div id="fullScreenMenuChangeLog" style="display: none;" >
		<?php require_once("changelog.php"); ?>
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
	<?php 
	if($samePageSettings === "true"):
		//auto generated settings tabs
		foreach ($defaultConfigMoreData as $currentSection => $configRowData): ?>
			<div id="<?php echo $configRowData["menu"]["id"]; ?>" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
				<?php include('core/php/template/varTemplate.php');	?>
			</div>
		<?php endforeach; ?>
		<?php //custom settings tabs ?>
		<div id="fullScreenMenuColorScheme" class="fullScreenMenuSettingsFormDiv" style="display: none;">
			<?php require_once('core/php/template/folderGroupColor.php'); ?>
		</div>
		<div id="settingsAdvancedDevConfig" class="fullScreenMenuSettingsFormDiv" style="display: none;">
			<?php
				require_once("core/php/template/devConfigSettings.php");
			?>
		</div>
		<div id="settingsMainLogLayout" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
			<?php
			require_once('core/php/template/logLayout.php');
			?>
		</div>
	<?php endif; //$samePageSettings === "true" ?>
</div>