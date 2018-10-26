<li class="menuTitle fullScreenMenuText" style="text-align: center;" >
	Log-Hog
</li>
<li class="menuTitle fullScreenMenuText" style="background-color: #999; color: black;" >
	Main Menu
</li>
<li id="mainMenuAbout" class="selected" onclick="toggleAbout();" >
	<div class="menuImageDiv">
		<?php echo generateImage(
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
		<?php echo generateImage(
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
<li id="mainMenuNotifications" onclick="toggleNotifications();" >
	<div class="menuImageDiv">
		<?php echo generateImage(
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
	<span class="fullScreenMenuText">Notifications</span>
</li>
<li id="mainMenuSettings" onclick="toggleSettings();"  >
	<div class="menuImageDiv">
		<?php echo generateImage(
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
		<?php echo generateImage(
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
		<?php echo generateImage(
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
		<?php echo generateImage(
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
	<li id="menuOtherApps" class="menuTitle menuBreak" style="background-color: #999; color: black;
	<?php if(!($locationForMonitorIndex["loc"] || $locationForSearchIndex["loc"] || $locationForSeleniumMonitorIndex["loc"] || $locationForStatusIndex["loc"]))
		{
			echo " display: none; ";
		}
		?>
	" >
		<span class="fullScreenMenuText">Other Apps</span>
	</li>
<?php
$statusDisplay = "display: none;";
if($locationForStatusIndex["loc"])
{
	$statusDisplay = "";
}?>
	<?php if($addonsAsIframe === "true"): ?>
		<li id="menuStatusAddon" style="<?php echo $statusDisplay; ?>" onclick="toggleIframe('<?php echo $locationForStatusIndex["loc"]; ?>','menuStatusAddon');" >
	<?php else: ?>
		<li id="menuStatusAddon" style="<?php echo $statusDisplay; ?>" onclick="window.location.href='<?php echo $locationForStatusIndex["loc"]; ?>'" >
	<?php endif; ?>
		<div class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"gitStatusImage",
					"class"		=>	"menuImage mainMenuImage",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["gitStatus"]
					)
				);
			?>
		</div>
		<span class="fullScreenMenuText">gitStatus</span>
		<?php
		if($addonsAsIframe !== "true")
		{
			echo $externalLinkImage;
		}
		?>
	</li>
<?php
$monitorDisplay = "display: none;";
if($locationForMonitorIndex["loc"])
{
	$monitorDisplay = "";
}?>
<?php if($addonsAsIframe === "true"): ?>
	<li id="menuMonitorAddon" style="<?php echo $monitorDisplay; ?>" onclick="toggleIframe('<?php echo $locationForMonitorIndex["loc"]; ?>','menuMonitorAddon');" >
<?php else: ?>
	<li id="menuMonitorAddon" style="<?php echo $monitorDisplay; ?>" onclick="window.location.href='<?php echo $locationForMonitorIndex["loc"]; ?>'" >
<?php endif; ?>
		<div class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"taskmanagerImage",
					"class"		=>	"menuImage mainMenuImage",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["taskManager"]
					)
				);
			?>
		</div>
		<span class="fullScreenMenuText">Monitor</span>
		<?php
		if($addonsAsIframe !== "true")
		{
			echo $externalLinkImage;
		}
		?>
	</li>
<?php
$searchDisplay = "display: none;";
if($locationForSearchIndex["loc"])
{
	$searchDisplay = "";
}?>
	<?php if($addonsAsIframe === "true"): ?>
		<li id="menuSearchAddon" style="<?php echo $searchDisplay; ?>" onclick="toggleIframe('<?php echo $locationForSearchIndex["loc"]; ?>','menuSearchAddon');" >
	<?php else: ?>
		<li id="menuSearchAddon" style="<?php echo $searchDisplay; ?>" onclick="window.location.href='<?php echo $locationForSearchIndex["loc"]; ?>'" >
	<?php endif; ?>
		<div class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"searchImage",
					"class"		=>	"menuImage mainMenuImage",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["search"]
					)
				);
			?>
		</div>
		<span class="fullScreenMenuText">Search</span>
		<?php
		if($addonsAsIframe !== "true")
		{
			echo $externalLinkImage;
		}
		?>
	</li>
<?php
$seleniumMonitorDisplay = "display: none;";
if($locationForSeleniumMonitorIndex["loc"])
{
	$seleniumMonitorDisplay = "";
}?>
	<?php if($addonsAsIframe === "true"): ?>
		<li id="menuSeleniumMonitorAddon" style="<?php echo $seleniumMonitorDisplay; ?>" onclick="toggleIframe('<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>','menuSeleniumMonitorAddon');" >
	<?php else: ?>
		<li id="menuSeleniumMonitorAddon" style="<?php echo $seleniumMonitorDisplay; ?>" onclick="window.location.href='<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>'" >
	<?php endif; ?>
		<div class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"seleniumMonitorImage",
					"class"		=>	"menuImage mainMenuImage",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["seleniumMonitor"]
					)
				);
			?>
		</div>
		<span class="fullScreenMenuText">Selenium Monitor</span>
		<?php
		if($addonsAsIframe !== "true")
		{
			echo $externalLinkImage;
		}
		?>
	</li>