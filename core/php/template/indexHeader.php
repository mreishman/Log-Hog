<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: none;">
		<span id="menuButtonLeft">
			<div onclick="toggleFullScreenMenu();"  class="menuImageDiv" id="mainMenuDiv">
				<?php echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"menuImage",
						"class"		=>	"menuImage menuImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["menu"]
						)
					);
				?>
			</div>
			<div <?php if ($hideNotificationIcon === "true"){echo "style=\"display: none\"";} ?> class="menuImageDiv" id="notificationDiv" onclick="toggleNotifications();" >
				<?php echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"notificationNotClicked",
						"class"		=>	"menuImage notificationImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["notification"]
						)
					);
				?>
			</div>
			<div onclick="toggleSettingsSidebar();"  class="menuImageDiv">
				<?php echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"gearImage",
						"class"		=>	"menuImage gearImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["gear"]
						)
					);
				?>
			</div>
			<div onclick="pausePollAction();" class="menuImageDiv">
				<?php
					$styleString = "display: inline-block;";
					if($pausePoll !== 'true')
					{
						$styleString = "display: none;";
					}
					echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"playImage",
						"class"		=>	"menuImage playImageForLoad",
						"height"	=>	"30px",
						"style"		=>	$styleString,
						"data-src"	=>	$arrayOfImages["play"]
						)
					);

					$styleString = "display: inline-block;";
					if($pausePoll === 'true')
					{
						$styleString = "display: none;";
					}
					echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"pauseImage",
						"class"		=>	"menuImage pauseImageForLoad",
						"height"	=>	"30px",
						"style"		=>	$styleString,
						"data-src"	=>	$arrayOfImages["pause"]
						)
					);
				?>
			</div>
			<div onclick="refreshAction();" class="menuImageDiv">
				<?php
					echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"refreshImage",
						"class"		=>	"menuImage refreshImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["refresh"]
						)
					);

					echo $core->generateImage(
					$arrayOfImages["loading"],
					$imageConfig = array(
						"id"		=>	"refreshingImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px",
						"style"		=>	"display: none;"
						)
					);
				?>
			</div>
			<?php
			$imageForClear = $core->generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"deleteImage",
					"class"		=>	"menuImage eraserMultiImageForLoad",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["eraserMulti"]
					)
				);
			if($truncateLog == 'false'):
				$imageForClear = $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"deleteImage",
						"class"		=>	"menuImage eraserForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["eraser"]
						)
					);
			endif;?>
			<div <?php if($truncateLog === 'hide'){echo "style = 'display: none;'";}?> onclick="deleteImageAction();"  class="menuImageDiv">
				<?php echo $imageForClear;
				?>
			</div>
			<span id="clearNotificationsImageHolder" <?php if($hideClearAllNotifications === "true"){ echo "style=\" display: none; \""; }?> >
				<div  id="clearNotificationsImage" style="display: none;" onclick="removeAllNotifications();" class="menuImageDiv">
					<?php echo $core->generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"notificationClearImage",
							"class"		=>	"menuImage notificationClearImageForLoad",
							"height"	=>	"30px",
							"data-src"	=>	$arrayOfImages["notificationClear"]
							)
						);
					?>
				</div>
			</span>
		</span>
		<?php if ($groupDropdownInHeader === "true"): ?>
			<div id="groupsInHeader"><span id="groupHeaderAllButton" class="linkSmall selected" onclick="addGroupToSelect(event, 'all');" >All</span></div>
		<?php endif; ?>
		<div id="menuButtonRight" style="float: right; <?php if (!($filterSearchInHeader === "true" && $filterEnabled === "true")){ echo " display: none; "; }?> ">
			<span id="showFilterTopBarButton" style="cursor: pointer; padding-right: 5px;" onclick="showFilterTopBar()">
				<?php echo $core->generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"showFilterTopBarImage",
						"class"		=>	"menuImage showFilterTopBarImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["search"]
						)
					);
				?>
			</span>
			<span id="searchFieldGeneral" style="display: none;">
				<span onclick="hideFilterTopBar();" style="cursor: pointer;">
					<?php echo $core->generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"hideFilterTopBarImage",
							"class"		=>	"menuImage closeImageForLoad",
							"height"	=>	"30px",
							"data-src"	=>	$arrayOfImages["close"]
							)
						);
					?>
				</span>
				<input id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>">
			</span>
		</div>
	</div>
</div>