<form onsubmit="checkWatchList()" id="settingsMainWatch" >
	<div class="settingsHeader">
		WatchList
		<div class="settingsHeaderButtons">
			<a onclick="resetWatchListVars();" id="settingsMainWatchResetButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainWatch');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<span id="loadingSpan">
			<h1 id="progressBarMainInfoWatchList" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 100px; font-size: 150%;" >Loading...</h1>
			<div id="divForProgressBarWatchList" style="width: 80%; height: 100px; margin-left: auto; margin-right: auto; margin-top: -15px; margin-bottom: -15px;">
				<div <?php echo $loadingBarStyle; ?> class="ldBar label-center" id="progressBarWatchList" data-value="0" style="width: 100%; height: 100%; margin: auto;"></div>
			</div>
			<h3 id="progressBarSubInfoWatchList" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 10px; font-size: 150%;" >Loading Javascript</h3>
		</span>
		<ul class="settingsUl uniqueClassForAppendSettingsMainWatchNew" style=" -webkit-padding-start: 0;" >
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
					"data-src"	=>	$arrayOfImages["redWarning"]
				)
			); ?>
			 - File / Folder not found! &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"	=>	$arrayOfImages["yellowWarning"]
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
					"data-src"	=>	$arrayOfImages["fileIcon"]
				)
			); ?>
			 - File &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"	=>	$arrayOfImages["fileIconNR"]
				)
			); ?>
			 - File Not Readable &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"	=>	$arrayOfImages["folderIconNW"]
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
					"data-src"	=>	$arrayOfImages["folderIcon"]
				)
			); ?>
			 - Folder &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"	=>	$arrayOfImages["folderIconNR"]
				)
			); ?>
			 - Folder Not Readable &nbsp; &nbsp; &nbsp;
			<?php echo generateImage(
				$arrayOfImages["loadingImg"],
				array(
					"width"			=>	"25px",
					"class"			=>	"watchlistImg",
					"data-src"	=>	$arrayOfImages["fileIconNW"]
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
		<?php echo generateSaveBlock(array(), $arrayOfImages); ?>
	</div>
</div>
<div id="fileFolderDropdown" style="width: 600px; background-color: #444; border: 1px solid white; z-index: 120; position: fixed;"  >
</div>
<script type="text/javascript">
	var icons = {};
	var defaultTrashCanIcon 					= <?php echo json_encode(generateImage($arrayOfImages["trashCanSideBar"],array("height" => "25px")));?>;
	icons["defaultRedErrorIcon"]				= <?php echo json_encode(generateImage($arrayOfImages["redWarning"],array("width" => "25px")));?>;
	icons["defaultYellowErrorIcon "]			= <?php echo json_encode(generateImage($arrayOfImages["yellowWarning"],array("width" => "25px"))); ?>;
	icons["defaultFolderIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["folderIcon"],array("width" => "25px"))); ?>;
	icons["defaultFileIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIcon"],array("width" => "25px"))); ?>;
	icons["defaultFolderNRIcon"] 				= <?php echo json_encode(generateImage($arrayOfImages["folderIconNR"],array("width" => "25px"))); ?>;
	icons["defaultFileNRIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIconNR"],array("width" => "25px"))); ?>;
	icons["defaultFolderNWIcon"] 				= <?php echo json_encode(generateImage($arrayOfImages["folderIconNW"],array("width" => "25px"))); ?>;
	icons["defaultFileNWIcon"] 					= <?php echo json_encode(generateImage($arrayOfImages["fileIconNW"],array("width" => "25px"))); ?>;
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