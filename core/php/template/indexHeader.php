<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: block;">
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
		<div onclick="filterSubMenu();" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"id"		=>	"menuImage",
						"class"		=>	"menuImage filterImageForLoad",
						"height"	=>	"30px",
						"data-src"	=>	$arrayOfImages["filter"]
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
		<div style="float: right;">
			<input disabled id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>" style="height: 30px; width: 200px; margin-right: 10px;">
		</div>
	</div>
	<div id="menu2" style="display: none; position: inherit;">
		<div id="groupSubMenu" style="display: none;" >
			<?php if ($groupDropdownInHeader !== "true"): ?>
				Groups:
				<div class="selectDiv">
					<select id="selectForGroup" >
						<option selected="true" value="all" >All</option>
					</select>
				</div>
				|
			<?php endif; ?>
			Search:
			<div class="selectDiv" >
				<select id="searchType" disabled name="searchType">
					<option <?php if ($filterDefault === "title"){echo "selected"; }?> value="title">Title</option>
					<option <?php if ($filterDefault === "content"){echo "selected"; }?> value="content">Content</option>
				</select>
			</div>
			Case Insensitive:
			<div class="selectDiv" >
				<select onchange="changeFilterCase();" id="caseInsensitiveSearch">
					<option <?php if ($caseInsensitiveSearch === "true"){ echo "selected"; }?> value="true">True</option>
					<option <?php if ($caseInsensitiveSearch === "false"){ echo "selected"; }?> value="false">False</option>
				</select>
			</div>
			Title Includes Path:
			<div class="selectDiv" >
				<select onchange="changeFilterTitleIncludePath();" id="filterTitleIncludePath">
					<option <?php if ($filterTitleIncludePath === "true"){ echo "selected"; }?> value="true">True</option>
					<option <?php if ($filterTitleIncludePath === "false"){ echo "selected"; }?> value="false">False</option>
				</select>
			</div>
			Highlight Content Match:
			<div class="selectDiv" >
				<select onchange="changeHighlightContentMatch();" id="filterContentHighlight">
					<option <?php if ($filterContentHighlight === "true"){ echo "selected"; }?> value="true">True</option>
					<option <?php if ($filterContentHighlight === "false"){ echo "selected"; }?> value="false">False</option>
				</select>
			</div>
			Filter Content Match:
			<div class="selectDiv" >
				<select onchange="changeFilterContentMatch();" id="filterContentLimit">
					<option <?php if ($filterContentLimit === "true"){ echo "selected"; }?> value="true">True</option>
					<option <?php if ($filterContentLimit === "false"){ echo "selected"; }?> value="false">False</option>
				</select>
			</div>
			Line Padding:
			<div class="selectDiv" >
				<select onchange="changeFilterContentLinePadding();" id="filterContentLinePadding">
					<?php for($CFC = 0; $CFC < 10; $CFC++): ?>
						<option <?php if ($filterContentLinePadding === $CFC){ echo "selected"; }?> value="<?php echo $CFC; ?>"><?php echo $CFC; ?></option>
					<?php endfor; ?>
				</select>
			</div>
		</div>
	</div>
</div>