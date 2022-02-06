<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: none;">
		<span id="menuButtonLeft">
			<?php foreach ($sortedIndexHeaderConfig as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
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