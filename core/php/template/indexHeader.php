<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: block;">
		<div onclick="toggleFullScreenMenu();"  class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["menu"],
				$imageConfig = array(
					"id"		=>	"menuImage",
					"class"		=>	"menuImage",
					"height"	=>	"30px"
					)
				);
			?>
		</div>
		<div class="menuImageDiv" id="notificationDiv" onclick="toggleNotifications();" >
			<?php echo generateImage(
				$arrayOfImages["notification"],
				$imageConfig = array(
					"id"		=>	"notificationNotClicked",
					"class"		=>	"menuImage",
					"height"	=>	"30px"
					)
				);
			?>
			<?php echo generateImage(
				$arrayOfImages["notificationFull"],
				$imageConfig = array(
					"id"		=>	"notificationClicked",
					"class"		=>	"menuImage",
					"height"	=>	"30px",
					"style"		=>  "display: none;"
					)
				);
			?>
		</div>
		<div onclick="" class="menuImageDiv">
			<?php echo generateImage(
				$arrayOfImages["history"],
				$imageConfig = array(
					"id"		=>	"menuImage",
					"class"		=>	"menuImage",
					"height"	=>	"30px"
					)
				);
			?>
		</div>
		<?php if($enableMultiLog === "true" && $multiLogOnIndex === "true"): ?>
			<div onclick="multiLogPopup();"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["multiLog"],
					$imageConfig = array(
						"id"		=>	"menuImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
		<?php endif; ?>
		<div onclick="filterSubMenu();" id="selectForGroupDiv" style="display: none;" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["filter"],
					$imageConfig = array(
						"id"		=>	"menuImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
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
				$arrayOfImages["play"],
				$imageConfig = array(
					"id"		=>	"playImage",
					"class"		=>	"menuImage",
					"height"	=>	"30px",
					"style"		=>	$styleString
					)
				);

				$styleString = "display: inline-block;";
				if($pausePoll === 'true')
				{
					$styleString = "display: none;";
				}
				echo generateImage(
				$arrayOfImages["pause"],
				$imageConfig = array(
					"id"		=>	"pauseImage",
					"class"		=>	"menuImage",
					"height"	=>	"30px",
					"style"		=>	$styleString
					)
				);
			?>
		</div>
		<div onclick="refreshAction();" class="menuImageDiv">
			<?php
				echo generateImage(
				$arrayOfImages["refresh"],
				$imageConfig = array(
					"id"		=>	"refreshImage",
					"class"		=>	"menuImage",
					"height"	=>	"30px"
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
					$arrayOfImages["eraserMulti"],
					$imageConfig = array(
						"id"		=>	"deleteImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
		<?php elseif($truncateLog == 'false'): ?>
			<div onclick="clearLog(currentSelectWindow);" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["eraser"],
					$imageConfig = array(
						"id"		=>	"deleteImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
		<?php endif; ?>
		<span <?php if($hideClearAllNotifications === "true"){ echo "style=\" display: none; \""; }?> >
			<div  id="clearNotificationsImage" style="display: none;" onclick="removeAllNotifications();" class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["notificationClear"],
					$imageConfig = array(
						"id"		=>	"notificationClearImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
		</span>
		<div style="float: right;">
			<div class="selectDiv" >
				<select id="searchType" disabled name="searchType" style="height: 30px;">
					<option <?php if ($filterDefault === "title"){echo "selected"; }?> value="title">Title</option>
					<option <?php if ($filterDefault === "content"){echo "selected"; }?> value="content">Content</option>
				</select>
			</div>
			<input disabled id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>" style="height: 30px; width: 200px;">
			<div onclick="toggleFilterSettingsPopup();" style="display: inline-block; cursor: pointer;">
				<?php echo generateImage(
					$arrayOfImages["gear"],
					$imageConfig = array(
						"id"		=>	"filterGear",
						"class"		=>	"menuImage",
						"height"	=>	"15px",
						"title"		=>  "Filter Settings",
						"style"		=>  "margin-top: -15px;"
						)
					);
				?>
			</div>
		</div>
	</div>
	<div id="menu2" style="display: none; position: inherit;">
		<div id="subMenuForGroup" style="display: none;" >
			Log Layout
			<?php $arrayOfwindowConfigOptions = array();
			for ($i=0; $i < 3; $i++)
			{
				for ($j=0; $j < 3; $j++)
				{
					array_push($arrayOfwindowConfigOptions, "".($i+1)."x".($j+1));
				}
			}
			?>
			<div class="selectDiv">
				<select id="windowConfig">
					<?php foreach ($arrayOfwindowConfigOptions as $value)
					{
						$stringToEcho = "<option ";
						if($value === $windowConfig)
						{
							$stringToEcho .= " selected ";
						}
						$stringToEcho .= " value=\"".$value."\"> ".$value."</option>";
						echo $stringToEcho;
					}
					?>
				</select>
			</div>
			|
			Layout Version
			<span onclick="swapLayoutLetters('A');" class="linkSmall" >A</span>
			<span onclick="swapLayoutLetters('B');" class="linkSmall" >B</span>
			<span onclick="swapLayoutLetters('C');" class="linkSmall" >C</span>
			<input type="hidden" id="layoutVersionIndex" value="A" >
			|
			<span onclick="resetSelection();" class="linkSmall">Reset Selection</span>
		</div>
		<div id="groupSubMenu" style="display: none;" >
			Groups:
			<div class="selectDiv">
				<select id="selectForGroup" >
					<option selected="true" value="all" >All</option>
				</select>
			</div>
		</div>
	</div>
</div>