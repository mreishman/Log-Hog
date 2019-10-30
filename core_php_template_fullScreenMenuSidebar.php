<script type="text/javascript">
	addonRightClickObject = {};
	addonRightClickIds = {};
</script>
<li class="menuTitle fullScreenMenuText subMenuTitle">
	Main Menu
</li>
<li id="mainMenuAbout" onclick="toggleAbout();" >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"aboutImage",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["info"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">About</span>
</li>
<li id="mainMenuAddons" onclick="toggleAddons();" >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"addonsImage",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["addons"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">Addons</span>
</li>
<?php $historyStyle = "";
if($enableHistory === "false")
{
	$historyStyle = "display: none;";
}
?>
<li id="mainMenuHistory" style=" <?php echo $historyStyle; ?>" onclick="toggleHistory();" >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"addonsImage",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["history"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">History</span>
</li>
<li id="mainMenuNotifications" onclick="toggleNotifications();" >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"notificationImageMenuTmpId",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["notification"]
				)
			);
		?>
	</div>
	<span id="mainMenuNotificationsText" class="fullScreenMenuText">Notifications</span>
</li>
<!-- <li id="mainMenuProfiles">
	<span id="mainMenuProfilesText" class="fullScreenMenuText">Profiles</span>
</li> -->
<li id="mainMenuSettings" onclick="toggleSettings();"  >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"gear",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=> 	$arrayOfImages["gear"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">Settings</span>
</li>
<?php $themeStyle = "";
if($themesEnabled === "false")
{
	$themeStyle = "display: none;";
}
?>
<li id="ThemesLink" style=" <?php echo $themeStyle; ?>" onclick="toggleThemes();"  >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"theme",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"data-src"	=> 	$arrayOfImages["theme"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">Themes</span>
</li>
<li id="mainMenuUpdate" onclick="toggleUpdateMenu();" >
	<?php
	$menuUpdateImage = "refresh";
	if($levelOfUpdate !== 0 && $configStatic["version"] !== $dontNotifyVersion && $updateNotificationEnabled === "true")
	{
		if($updateNoticeMeter === "every" || $levelOfUpdate > 1)
		{
			if($levelOfUpdate == 1)
			{
				$menuUpdateImage = "updateYellow";
			}
			elseif($levelOfUpdate == 2 || $levelOfUpdate == 3)
			{
				$menuUpdateImage = "updateRed";
			}
		}
	}
	?>
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"update",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"title"		=>	"Update",
				"data-src"	=>	$arrayOfImages[$menuUpdateImage]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">Update</span>
</li>
<li id="watchListMenu" onclick="toggleWatchListMenu();" >
	<div class="menuImageDiv">
		<?php echo $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"watchList",
				"class"		=>	"menuImage mainMenuImage",
				"height"	=>	"30px",
				"title"		=>	"WatchList",
				"data-src"	=>	$arrayOfImages["watchList"]
				)
			);
		?>
	</div>
	<span class="fullScreenMenuText">Watchlist</span>
</li>
<span id="menuAddonLinks">
	<?php require_once("addonLinksSideBar.php"); ?>
</span>