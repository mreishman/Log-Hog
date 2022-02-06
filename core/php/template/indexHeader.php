<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: none;">
		<span id="menuButtonLeft">
			<?php foreach ($sortedIndexHeaderConfigLeft as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
		</span>
		<?php if ($groupDropdownInHeader === "true"): ?>
			<div id="groupsInHeader"><span id="groupHeaderAllButton" class="linkSmall selected" onclick="addGroupToSelect(event, 'all');" >All</span></div>
		<?php endif; ?>
		<div id="menuButtonRight" style="float: right;">
			<?php foreach ($sortedIndexHeaderConfigRight as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
		</div>
	</div>
</div>