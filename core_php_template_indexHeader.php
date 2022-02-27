<div class="backgroundForMenus" id="header" >
	<div id="menuButtons" style="display: none;">
		<span id="menuButtonLeft">
			<?php foreach ($sortedIndexHeaderConfigLeft as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
		</span>
		<span id="menuButtonMiddle">
			<?php foreach ($sortedIndexHeaderConfigCenter as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
		</span>
		<div id="menuButtonRight" style="float: right;">
			<?php foreach ($sortedIndexHeaderConfigRight as $headerItem)
			{
				include("core/php/template/indexHeaderAction.php");
			}?>
		</div>
	</div>
</div>