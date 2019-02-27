<script type="text/javascript">
	addonRightClickObject = {};
	addonRightClickIds = {};
</script>
<li class="menuTitle fullScreenMenuText" style="text-align: center;" >
	Log-Hog
</li>
<li class="menuTitle fullScreenMenuText subMenuTitle">
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
<?php $historyStyle = "";
if($enableHistory === "false")
{
	$historyStyle = "display: none;";
}
?>
<li id="mainMenuHistory" style=" <?php echo $historyStyle; ?>" onclick="toggleHistory();" >
	<div class="menuImageDiv">
		<?php echo generateImage(
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
	<span id="mainMenuNotificationsText" class="fullScreenMenuText">Notifications</span>
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
	<li id="menuOtherApps" class="menuTitle menuBreak subMenuTitle" style="
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
	<li id="menuStatusAddon" style="<?php echo $statusDisplay; ?>" >
	<?php if($addonsAsIframe === "true"): ?>
		<span id="statusSpan" onclick="toggleIframe('<?php echo $locationForStatusIndex["loc"]; ?>','menuStatusAddon');" >
	<?php else: ?>
		<a id="statusSpan" href="<?php echo $locationForStatusIndex["loc"]; ?>" target="_blank" >
	<?php endif; ?>
			<div id="statusDiv" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"statusImage",
						"class"		=>	"menuImage mainMenuImage",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["gitStatus"]
						)
					);
				?>
			</div>
			<span id="statusText" class="fullScreenMenuText">gitStatus</span>
			<?php
			if($addonsAsIframe !== "true")
			{
				echo $externalLinkImage;
			}
		if($addonsAsIframe === "true"): ?>
			</span>
			<script type="text/javascript">
				addonRightClickObject["status"] = {action: "window.open(\"<?php echo $locationForStatusIndex["loc"]; ?>\");", name: "Open in new tab"};
			</script>
		<?php else: ?>
			</a>
			<script type="text/javascript">
				addonRightClickObject["status"] = {action: "toggleIframe(\"<?php echo $locationForStatusIndex["loc"]; ?>\",\"menuStatusAddon\");", name: "Open in iframe"};
			</script>
		<?php endif; ?>
		<script type="text/javascript">
			addonRightClickIds["status"] = "menuStatusAddon";
		</script>
	</li>
<?php
$monitorDisplay = "display: none;";
if($locationForMonitorIndex["loc"])
{
	$monitorDisplay = "";
}?>
	<li id="menuMonitorAddon" style="<?php echo $monitorDisplay; ?>" >
	<?php if($addonsAsIframe === "true"): ?>
		<span id="MonitorSpan" onclick="toggleIframe('<?php echo $locationForMonitorIndex["loc"]; ?>','menuMonitorAddon');" >
	<?php else: ?>
		<a id="MonitorSpan" href="<?php echo $locationForMonitorIndex["loc"]; ?>" target="_blank" >
	<?php endif; ?>
			<div id="MonitorDiv" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"MonitorImage",
						"class"		=>	"menuImage mainMenuImage",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["taskManager"]
						)
					);
				?>
			</div>
			<span id="MonitorText" class="fullScreenMenuText">Monitor</span>
			<?php
			if($addonsAsIframe !== "true")
			{
				echo $externalLinkImage;
			}
		if($addonsAsIframe === "true"): ?>
			</span>
			<script type="text/javascript">
				addonRightClickObject["Monitor"] = {action: "window.open(\"<?php echo $locationForMonitorIndex["loc"]; ?>\");", name: "Open in new tab"};
			</script>
		<?php else: ?>
			</a>
			<script type="text/javascript">
				addonRightClickObject["Monitor"] = {action: "toggleIframe(\"<?php echo $locationForMonitorIndex["loc"]; ?>\",\"menuMonitorAddon\");", name: "Open in iframe"};
			</script>
		<?php endif; ?>
		<script type="text/javascript">
			addonRightClickIds["Monitor"] = "menuMonitorAddon";
		</script>
	</li>
<?php
$searchDisplay = "display: none;";
if($locationForSearchIndex["loc"])
{
	$searchDisplay = "";
}?>
	<li id="menuSearchAddon" style="<?php echo $searchDisplay; ?>">
	<?php if($addonsAsIframe === "true"): ?>
		<span id="SearchSpan" onclick="toggleIframe('<?php echo $locationForSearchIndex["loc"]; ?>','menuSearchAddon');" >
	<?php else: ?>
		<a id="SearchSpan" href="<?php echo $locationForSearchIndex["loc"]; ?>" target="_blank" >
	<?php endif; ?>
			<div id="SearchDiv" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"SearchImage",
						"class"		=>	"menuImage mainMenuImage",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["search"]
						)
					);
				?>
			</div>
			<span id="SearchText" class="fullScreenMenuText">Search</span>
			<?php
			if($addonsAsIframe !== "true")
			{
				echo $externalLinkImage;
			}
		if($addonsAsIframe === "true"): ?>
			</span>
			<script type="text/javascript">
				addonRightClickObject["Search"] = {action: "window.open(\"<?php echo $locationForSearchIndex["loc"]; ?>\");", name: "Open in new tab"};
			</script>
		<?php else: ?>
			</a>
			<script type="text/javascript">
				addonRightClickObject["Search"] = {action: "toggleIframe(\"<?php echo $locationForSearchIndex["loc"]; ?>\",\"menuSearchAddon\");", name: "Open in iframe"};
			</script>
		<?php endif; ?>
		<script type="text/javascript">
			addonRightClickIds["Search"] = "menuSearchAddon";
		</script>
	</li>
<?php
$seleniumMonitorDisplay = "display: none;";
if($locationForSeleniumMonitorIndex["loc"])
{
	$seleniumMonitorDisplay = "";
}?>
	<li id="menuSeleniumMonitorAddon" style="<?php echo $seleniumMonitorDisplay; ?>">
	<?php if($addonsAsIframe === "true"): ?>
		<span id="seleniumMonitorSpan" onclick="toggleIframe('<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>','menuSeleniumMonitorAddon');" >
	<?php else: ?>
		<a  id="seleniumMonitorSpan" href="<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>" target="_blank" >
	<?php endif; ?>
			<div id="seleniumMonitorDiv" class="menuImageDiv">
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
			<span id="seleniumMonitorText" class="fullScreenMenuText">Selenium Monitor</span>
			<?php
			if($addonsAsIframe !== "true")
			{
				echo $externalLinkImage;
			}
		if($addonsAsIframe === "true"): ?>
			</span>
			<script type="text/javascript">
				addonRightClickObject["seleniumMonitor"] = {action: "window.open(\"<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>\");", name: "Open in new tab"};
			</script>
		<?php else: ?>
			</a>
			<script type="text/javascript">
				addonRightClickObject["seleniumMonitor"] = {action: "toggleIframe(\"<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>\",\"menuSeleniumMonitorAddon\");", name: "Open in iframe"};
			</script>
		<?php endif; ?>
		<script type="text/javascript">
			addonRightClickIds["seleniumMonitor"] = "menuSeleniumMonitorAddon";
		</script>
	</li>