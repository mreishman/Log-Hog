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

if(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
} 
if(array_key_exists('expSettingsAvail', $config))
{
	$expSettingsAvail = $config['expSettingsAvail'];
}
else
{
	$expSettingsAvail = $defaultConfig['expSettingsAvail'];
}
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php');

if(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
?>
	
	

	<div id="main">
		<form id="settingsMainVars" action="../core/php/settingsMainUpdateVars.php" method="post">
		<div class="settingsHeader">
		Main Settings <button>Save Changes</button>
		</div>
		<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				sliceSize:  <input type="text" name="sliceSize" value="<?php echo $sliceSize;?>" > Lines
			</li>
			<li>
				pollingRate: <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Milliseconds
			</li>
			<li>
				pausePoll: 
					<select name="pausePoll">
  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				pauseOnNotFocus:
					<select name="pauseOnNotFocus">
  						<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
			</li>
			<li>
				autoCheckUpdate:
					<select name="autoCheckUpdate">
  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
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
 				<a style="cursor: pointer;" onclick="deleteRowFunction(<?php echo $i; ?>, true)">Remove File / Folder</a>
			</li>

		<?php endforeach; ?>
		<div id="newRowLocationForWatchList">
		</div>
		</ul>
		<ul id="settingsUl">
			<li>
				<a style="cursor: pointer;" onclick="addRowFunction()">Add New File / Folder</a>
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
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
	document.getElementById("mainLink").classList.add("active");
</script>
<script type="text/javascript"> 
var countOfWatchList = <?php echo $i; ?>;
var countOfAddedFiles = 0;
function addRowFunction()
{

	countOfWatchList++;
	if(countOfWatchList < 10)
	{
		document.getElementById('newRowLocationForWatchList').innerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a style='cursor: pointer;' onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove File / Folder</a></li>";
	}
	else
	{
		document.getElementById('newRowLocationForWatchList').innerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a style='cursor: pointer;' onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove File / Folder</a></li>";
	}
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
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
				documentUpdateText += ' <a style="cursor: pointer;" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove File / Folder</a>';
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

</script>







	
