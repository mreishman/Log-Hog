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

$today = date('Y-m-d');
$old_date = $configStatic['lastCheck'];
$old_date_array = split("-", $old_date);
$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];
//$old_date = date_format( $old_date ,"Y-m-d");          
//$old_date_timestamp = strtotime($old_date);
//$new_date = date('Y-m-d', $old_date_timestamp); 

$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
$datetime2 = date_create($today);
$interval = date_diff($datetime1, $datetime2);
$daysSince = $interval->format('%a');
?>
<!doctype html>
<head>
	<title>Settings | Update</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	
	<div id="main">
		<div class="settingsHeader">
			Update
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Current Version - <?php echo $configStatic['version'];?></h2>
				</li>	
				<li>
					<h2>Last Check for updates -  <span id="spanNumOfDaysUpdateSince" ><?php echo $daysSince;?> Day<?php if($daysSince != 1){ echo "s";} ?></span> Ago</h2>
				</li>
				<li>
					<form id="settingsCheckForUpdate" action="../core/php/settingsCheckForUpdate.php" method="post" style="float: left; padding: 10px;">
					<button onclick="displayLoadingPopup();" >Check for updates</button>
					<a class="link" onclick="checkForUpdates();">Check for updates - ajax</a>
					</form>
					<form id="settingsCheckForUpdate" action="../update/updater.php" method="post" style="padding: 10px;">
					<?php
					if($levelOfUpdate != 0){echo '<button onclick="installUpdates();">Install '.$configStatic["newestVersion"].' Update</button>';}
					?>
					</form>
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage1" src="../core/img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage2" src="../core/img/yellowWarning.png" height="15px"> &nbsp; Minor Updates - <?php echo $configStatic['newestVersion'];?> - bug fixes </h2>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="../core/img/redWarning.png" height="15px"> &nbsp; Major Updates - <?php echo $configStatic['newestVersion'];?> - new features!</h2>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="../core/img/redWarning.png" height="15px"><img id="statusImage3" src="../core/img/redWarning.png" height="15px"><img id="statusImage3" src="../core/img/redWarning.png" height="15px"> &nbsp; Very Major Updates - <?php echo $configStatic['newestVersion'];?> - a lot of new features!</h2>
				</li>
			</ul>
		</div>
		<div id="releaseNotesHeader" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsHeader">
			Update - Release Notes
		</div>
		<div id="releaseNotesBody" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsDiv" >
			<ul id="settingsUl">
			<?php 
			if(array_key_exists('versionList', $configStatic))
			{
				foreach ($configStatic['versionList'] as $key => $value) 
				{
					$version = explode('.', $configStatic['version']);
					$newestVersion = explode('.', $key);
					$levelOfUpdate = 0;
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
					if($levelOfUpdate != 0)
					{
						echo "<li><h2>Changelog For ".$key." update</h2></li>";
						echo $value['releaseNotes'];
					}
				}
			}
			
			?>
			</ul>
		</div>
		<div class="settingsHeader">
			Changelog
		</div>
		<?php readfile('changelog.html') ?>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
	document.getElementById("updateLink").classList.add("active");

	function goToUrl(url)
	{
		window.location.href = url;
	}

	function checkForUpdates()
	{
		displayLoadingPopup();
		$.getJSON('../core/php/settingsCheckForUpdateAjax.php', {}, function(data) 
		{
			if(data == "1" || data == "2" | data == "3")
			{
				
			}
			else if (data == "0")
			{
				hidePopup();
				showPopup();
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >No Update Needed</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
			}
			else
			{
				hidePopup();

			}
			
		});
	}

	function closePopupNoUpdate()
	{
		document.getElementById("spanNumOfDaysUpdateSince").innerHTML = "0 Days";
		hidePopup();
	}
</script>