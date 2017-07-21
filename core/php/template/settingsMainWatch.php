<form onsubmit="checkWatchList()" id="settingsMainWatch" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
	WatchList
	<div class="settingsHeaderButtons">
		<a onclick="resetWatchListVars();" id="resetChangesSettingsHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
		<button >Save Changes</button>
	</div>
</div>
<div class="settingsDiv" >	
<ul id="settingsUl">
	<?php 
		$i = 0;
		$triggerSaveUpdate = false;
		foreach($config['watchList'] as $key => $item): $i++;
		if(file_exists($key))
		{
			$perms  =  fileperms($key); 

			switch ($perms & 0xF000) {
			    case 0xC000: // socket
			        $info = 's';
			        break;
			    case 0xA000: // symbolic link
			        $info = 'l';
			        break;
			    case 0x8000: // regular
			        $info = 'f';
			        break;
			    case 0x6000: // block special
			        $info = 'b';
			        break;
			    case 0x4000: // directory
			        $info = 'd';
			        break;
			    case 0x2000: // character special
			        $info = 'c';
			        break;
			    case 0x1000: // FIFO pipe
			        $info = 'p';
			        break;
			    default: // unknown
			        $info = 'u';
			}

			// Owner
			$info .= (($perms & 0x0100) ? 'r' : '-');
			$info .= (($perms & 0x0080) ? 'w' : '-');
			$info .= (($perms & 0x0040) ?
			            (($perms & 0x0800) ? 's' : 'x' ) :
			            (($perms & 0x0800) ? 'S' : '-'));

			// Group
			$info .= (($perms & 0x0020) ? 'r' : '-');
			$info .= (($perms & 0x0010) ? 'w' : '-');
			$info .= (($perms & 0x0008) ?
			            (($perms & 0x0400) ? 's' : 'x' ) :
			            (($perms & 0x0400) ? 'S' : '-'));

			// World
			$info .= (($perms & 0x0004) ? 'r' : '-');
			$info .= (($perms & 0x0002) ? 'w' : '-');
			$info .= (($perms & 0x0001) ?
			            (($perms & 0x0200) ? 't' : 'x' ) :
			            (($perms & 0x0200) ? 'T' : '-'));
		}
		else
		{
			$info = "u---------";
		}

		if(strpos($item, "\\") !== false)
		{
			$item = str_replace("\\", "", $item);
			$triggerSaveUpdate = true;
		}
		?>
	<li id="rowNumber<?php echo $i; ?>" >
		File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: &nbsp; <?php echo $info; ?> &nbsp;
		<?php
		if(!file_exists($key))
		{
			echo '<img id="fileNotFoundImage'.$i.'" src="../core/img/redWarning.png" height="10px">';
		}
		?> 
			<input style='width: <?php if(!file_exists($key)){echo "480";}else{echo "500";}?>px ' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
			<input type='text' name='watchListItem<?php echo $i; ?>' value='<?php echo $item; ?>'>
			<a class="link" onclick="deleteRowFunctionPopup(<?php echo $i; ?>, true, '<?php echo $key; ?>')">Remove File / Folder</a>
	</li>

<?php endforeach; ?>
<div id="newRowLocationForWatchList">
</div>
</ul>
<ul id="settingsUl">
	<li>
		<a class="link" onclick="addRowFunction()">Add New File / Folder</a>
	</li>
	<li>
		<div class="settingsHeader">
			Key
		</div>
	</li>
	<li>
		<ul id="settingsUl">
			<li>
				<img src="../core/img/redWarning.png" height="10px"> - File / Folder not found!
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
	</li>
</ul>
</div>
<div id="hidden" style="display: none">
	<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
</div>	
</form>
<?php $folderCount = $i; ?>