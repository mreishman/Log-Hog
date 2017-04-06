<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main">
		<form id="settingsMainVars" action="../core/php/settingsMainUpdateVars.php" method="post">
		<div class="settingsHeader">
		Main Settings <button>Save Changes</button>
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				<span class="settingsBuffer" > Slice Size:</span>  <input type="text" name="sliceSize" value="<?php echo $sliceSize;?>" > Lines
			</li>
			<li>
				<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Milliseconds
			</li>
			<li>
				<span class="settingsBuffer" > Pause Poll By Default:  </span> 
					<select name="pausePoll">
  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Pause On Not Focus: </span> 
					<select name="pauseOnNotFocus">
  						<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Auto Check Update: </span> 
					<select name="autoCheckUpdate">
  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Truncate Log Button: </span> 
					<select name="truncateLog">
  						<option <?php if($truncateLog == 'true'){echo "selected";} ?> value="true">All Logs</option>
  						<option <?php if($truncateLog == 'false'){echo "selected";} ?> value="false">Current Log</option>
					</select>
			</li>
			<li>
				<span class="settingsBuffer" > Popup Warnings: </span> 
					<select id="popupSelect"  name="popupWarnings">
  						<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
  						<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
  						<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
					</select>
				<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

				<div class="settingsHeader">
					Popup Settings
					</div>
					<div class="settingsDiv" >
					<ul id="settingsUl">
					<?php foreach ($popupWarningsArray as $key => $value):?>
						<li>
						<span class="settingsBuffer" > <?php echo $key;?>: </span> 
							<select name="truncateLog">
		  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
		  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
							</select>
						</li>
					<?php endforeach;?>
					</ul>
					</div>
				</div>
			</li>
		</ul>
		</div>
		</form>
		<form id="settingsMainWatch" action="../core/php/settingsMainUpdateWatchList.php" method="post">
		<div class="settingsHeader">
			WatchList <button>Save Changes</button>
		</div>
		<div class="settingsDiv" >	
		<ul id="settingsUl">
			<?php 
				$i = 0;
				foreach($config['watchList'] as $key => $item): $i++; ?>
			<li id="rowNumber<?php echo $i; ?>" >
				File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>:
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
				</ul>
			</li>
		</ul>
		</div>
		<div id="hidden" style="display: none">
			<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
		</div>	
		</form>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
document.getElementById("mainLink").classList.add("active");
document.getElementById("popupSelect").addEventListener("change", showOrHidePopupSubWindow, false);
var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
var countOfWatchList = <?php echo $i; ?>;
var countOfAddedFiles = 0;
var countOfClicks = 0;
var locationInsert = "newRowLocationForWatchList";
function addRowFunction()
{

	countOfWatchList++;
	countOfClicks++;
	if(countOfWatchList < 10)
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link'  onclick='deleteRowFunctionPopup("+ countOfWatchList +", true)'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	else
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link' onclick='deleteRowFunctionPopup("+ countOfWatchList +", true)'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
}

function deleteRowFunctionPopup(currentRow, decreaseCountWatchListNum, keyName = "")
{
	if(popupSettingsArray.removeFolder == "true")
	{
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this file/folder?</div><br><div style='width:100%;text-align:center;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+","+ decreaseCountWatchListNum+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}
	else
	{
		deleteRowFunction(currentRow, decreaseCountWatchListNum);
	}
	
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(decreaseCountWatchListNum)
	{
		newValue = document.getElementById('numberOfRows').value;
		if(currentRow < newValue)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= newValue; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = "rowNumber" + i;
				var documentUpdateText = "<li id='rowNumber"+updateItoIMinusOne+"' >File #";
				var watchListKeyIdFind = "watchListKey"+i;
				var watchListItemIdFind = "watchListItem"+i;
				var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
				var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
				if(updateItoIMinusOne < 10)
				{
					documentUpdateText += "0";
				}
				documentUpdateText += updateItoIMinusOne+": ";
				var nameForId = "fileNotFoundImage" + i;
				var elementByIdPreCheck = document.getElementById(nameForId);
				if(elementByIdPreCheck !== null)
				{
					documentUpdateText += '<img id="fileNotFoundImage'+updateItoIMinusOne+'" src="../core/img/redWarning.png" height="10px">';
				}
				documentUpdateText += "<input style='width: ";
				if(elementByIdPreCheck !== null)
				{
					documentUpdateText += '480';
				}
				else
				{
					documentUpdateText += '500';
				}
				documentUpdateText += "px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				documentUpdateText += ' <a class="link" onclick="deleteRowFunctionPopup('+updateItoIMinusOne+', true,'+"'"+previousElementNumIdentifierForKey[0].value+"'"+')">Remove File / Folder</a>';
				documentUpdateText += '</li>';
				document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
			}
		}
		newValue--;
		if(countOfAddedFiles > 0)
		{
			countOfAddedFiles--;
			countOfWatchList--;
		}
		document.getElementById('numberOfRows').value = newValue;
	}

}	
function showOrHidePopupSubWindow()
{
	var valueForPopup = document.getElementById('popupSelect').value;
	console.log(valueForPopup);
	if(valueForPopup == 'custom')
	{
		document.getElementById('settingsPopupVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsPopupVars').style.display = 'none';
	}
}
</script>







	
