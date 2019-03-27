<form onsubmit="checkWatchList()" id="settingsMainWatch" >
	<div class="settingsHeader">
		WatchList
		<div class="settingsHeaderButtons">
			<a onclick="resetWatchListVars();" style="display: none;" class="linkSmall settingsMainWatchResetButton" > Reset Current Changes</a>
			<a style="display: none;" class="linkSmall settingsMainWatchSaveChangesButton" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<span id="loadingSpan">
			<h1 id="progressBarMainInfoWatchList" class="progressBarMainInfo">Loading...</h1>
			<div id="divForProgressBarWatchList" class="divForProgressBar">
				<div <?php echo $loadingBarStyle; ?> class="ldBar label-center progressBar" id="progressBarWatchList" data-value="0"></div>
			</div>
			<h3 id="progressBarSubInfoWatchList" class="progressBarSubInfo">Loading Javascript</h3>
		</span>
		<ul class="settingsUl uniqueClassForAppendSettingsMainWatchNew">
		</ul>
	</div>
	<div id="hidden" style="display: none">
		<input id="numberOfRows" type="text" name="numberOfRows" value="0">
	</div>
</form>
<div class="settingsHeader" id="watchKey" >
	Key
</div>
<div class="settingsDiv" >
	<ul class="settingsUl">
		<li>
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["redWarning"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - File / Folder not found! &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["yellowWarning"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - Unknown
		</li>
		<li>
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["fileIcon"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - File &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["fileIconNR"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - File Not Readable &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["folderIconNW"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - File Not Writeable
		</li>
		<li>
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["folderIcon"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - Folder &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["folderIconNR"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - Folder Not Readable &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"		=>	$arrayOfImages["fileIconNW"],
					"srcModifier"	=>	$imageUrlModifier
				)
			); ?>
			 - Folder Not Writeable &nbsp; &nbsp; &nbsp;
		</li>
		<li>
			f - file &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			d - directory &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			u - unknown / file not found &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			r - readable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			w - writeable &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
			x - executable
		</li>
	</ul>
</div>
<div id="storage">
	<div class="saveBlock">
		<?php echo generateSaveBlock(array('srcModifier' => $imageUrlModifier), $arrayOfImages); ?>
	</div>
</div>
<div id="fileFolderDropdown" class="addBorder addBackground" style="display: none;"  >
</div>
<script type="text/javascript">
	var icons = {};
	var defaultTrashCanIcon 					= <?php echo json_encode(generateImage($arrayOfImages["trashCanSideBar"],array("height" => "25px","srcModifier"	=>	$imageUrlModifier)));?>;
	icons["defaultRedErrorIcon"]				= <?php echo json_encode(generateImage($arrayOfImages["redWarning"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier)));?>;
	icons["defaultYellowErrorIcon "]			= <?php echo json_encode(generateImage($arrayOfImages["yellowWarning"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFolderIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["folderIcon"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFileIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIcon"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFolderNRIcon"] 				= <?php echo json_encode(generateImage($arrayOfImages["folderIconNR"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFileNRIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIconNR"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFolderNWIcon"] 				= <?php echo json_encode(generateImage($arrayOfImages["folderIconNW"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	icons["defaultFileNWIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIconNW"],array("width" => "25px","srcModifier"	=>	$imageUrlModifier))); ?>;
	var defaultdefaultNewAddAlertEnabled 	= "<?php echo $defaultNewAddAlertEnabled; ?>";
	var defaultNewAddAutoDeleteFiles 		= "<?php echo $defaultNewAddAutoDeleteFiles; ?>";
	var defaultNewAddExcludeTrim 			= "<?php echo $defaultNewAddExcludeTrim; ?>";
	var defaultNewAddPattern 				= "<?php echo $defaultNewAddPattern;?>";
	var defaultNewAddRecursive 				= "<?php echo $defaultNewAddRecursive;?>";
	var defaultNewPathFile 					= "<?php echo $defaultNewPathFile; ?>";
	var defaultNewPathFolder				= "<?php echo $defaultNewPathFolder;?>";
	var defaultNewPathOther 				= "<?php echo $defaultNewPathOther;?>";
	var sortTypeFileFolderPopup				= "<?php echo $sortTypeFileFolderPopup; ?>";
</script>