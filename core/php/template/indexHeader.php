<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: none;">
		<div onclick="toggleFullScreenMenu();"  class="menuImageDiv" id="mainMenuDiv">
			<?php echo generateImage(
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
			<?php echo generateImage(
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
		<div <?php if ($enableHistory !== "true"){echo "style=\"display: none\"";} ?>  onclick="archiveLogPopupToggle();" class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"historyImage",
					"class"		=>	"menuImage historyImageForLoad",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["history"]
					)
				);
			?>
		</div>
		<div onclick="toggleSettingsSidebar();"  class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"menuImage",
					"class"		=>	"menuImage gearImageForLoad",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["gear"]
					)
				);
			?>
		</div>
		<?php if($enableMultiLog === "true" && $multiLogOnIndex === "true"): ?>
			<div onclick="toggleSettingsSidebar();"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"multiLogImage",
						"class"		=>	"menuImage multiLogImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["multiLog"]
						)
					);
				?>
			</div>
		<?php endif; ?>
		<div onclick="pausePollAction();" class="menuImageDiv">
			<?php
				$styleString = "display: inline-block;";
				if($pausePoll !== 'true')
				{
					$styleString = "display: none;";
				}
				echo generateImage(
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
				echo generateImage(
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
				echo generateImage(
				$arrayOfImages["loadingImg"],
				$imageConfig = array(
					"id"		=>	"refreshImage",
					"class"		=>	"menuImage refreshImageForLoad",
					"height"	=>	"30px",
					"data-src"	=>	$arrayOfImages["refresh"]
					)
				);

				echo generateImage(
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
		<?php if($truncateLog == 'true'): ?>
			<div onclick="deleteAction();"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"deleteImage",
						"class"		=>	"menuImage eraserMultiImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["eraserMulti"]
						)
					);
				?>
			</div>
		<?php elseif($truncateLog == 'false'): ?>
			<div onclick="clearLog(currentSelectWindow);" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"deleteImage",
						"class"		=>	"menuImage eraserForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["eraser"]
						)
					);
				?>
			</div>
		<?php endif; ?>
		<span <?php if($hideClearAllNotifications === "true"){ echo "style=\" display: none; \""; }?> >
			<div  id="clearNotificationsImage" style="display: none;" onclick="removeAllNotifications();" class="menuImageDiv">
				<?php echo generateImage(
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
		<?php if ($groupDropdownInHeader === "true"): ?>
			<div class="selectDiv">
				<select id="selectForGroup" >
					<option selected="true" value="all" >All</option>
				</select>
			</div>
		<?php endif; ?>
		<?php if ($filterSearchInHeader === "true" && $filterEnabled === "true"): ?>
			<div style="float: right;">
				<input disabled id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>" style="height: 30px; width: 200px; margin-right: 10px;">
			</div>
		<?php endif; ?>
	</div>
</div>