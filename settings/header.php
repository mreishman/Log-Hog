<div id="menu">
	<div onclick="window.location.href = '../index.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
	</div>
	<a id="mainLink" onclick="window.location.href = 'main.php';" >Main</a>
	<a id="aboutLink" onclick="window.location.href = 'about.php';">About</a>
	<a id="updateLink" onclick="window.location.href = 'update.php';"><?php  if($levelOfUpdate == 1){echo '<img src="../core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="../core/img/redWarning.png" height="10px">';} ?>Update</a>
	<a id="advancedLink" onclick="window.location.href = 'advanced.php';">Advanced</a>
	<?php
	if($developmentTabEnabled == 'true'):?>
		<a id="devToolsLink" onclick="window.location.href = 'devTools.php';"> Dev Tools </a>
	<?php endif; ?>
	<?php
	if($expSettingsAvail):?>
		<a id="experimentalfeaturesLink" onclick="window.location.href = 'experimentalfeatures.php';"> Experimental Features </a>
	<?php endif; ?>
</div>