<?php
require_once('../core/php/commonFunctions.php');

$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

$fileNameArray = array(
	"LocalConfig"	=> array(
		"name"		=>	"Local Config",
		"path"		=>	'local/'.$currentSelectedTheme.'/conf/config.php'
	),
	"CoreConfig"	=>	array(
		"name"		=>	"Core Config",
		"path"		=>	"core/conf/config.php"
	),
	"ConfigStatic"	=>	array(
		"name"		=>	"Config Static",
		"path"		=>	"core/php/configStatic.php"
	),
	"loadVars"		=>	array(
		"name"		=>	"Load Vars",
		"path"		=>	"core/php/loadVars.php"
	),
	"UpdateCheck"	=>	array(
		"name"		=>	"Update Check",
		"path"		=>	"core/php/updateCheck.php"
	),
	"checkVersionOfConfig"	=>	array(
		"name"		=>	"Check Version Of Config",
		"path"		=>	"core/php/checkVersionOfConfig.php"
	),
	"checkVersionOfLayout"	=>	array(
		"name"		=>	"Check Version Of Layout",
		"path"		=>	"core/php/checkVersionOfLayout.php"
	),
	"commonFunctions"	=>	array(
		"name"		=>	"Common Functions",
		"path"		=>	"core/php/commonFunctions.php"
	),
	"configStaticCheck"	=>	array(
		"name"		=>	"Config Static Check",
		"path"		=>	"core/php/configStaticCheck.php"
	),
	"getPercentUpdate"	=>	array(
		"name"		=>	"Get Percent Update",
		"path"		=>	"core/php/getPercentUpdate.php"
	),
	"performSettingsInstallUpdateAction"	=>	array(
		"name"		=>	"Perform Settings Install Update Action",
		"path"		=>	"core/php/performSettingsInstallUpdateAction.php"
	),
	"updateActionFile"	=>	array(
		"name"		=>	"Update Action File",
		"path"		=>	"core/php/updateActionFile.php"
	),
	"updateProgressFile"	=>	array(
		"name"		=>	"Update Progress File",
		"path"		=>	"core/php/updateProgressFile.php"
	),
	"updateProgressFileNext"	=>	array(
		"name"		=>	"Update Progress File Next",
		"path"		=>	"core/php/updateProgressFileNext.php"
	),
	"versionCheck"	=>	array(
		"name"		=>	"Version Check",
		"path"		=>	"core/php/versionCheck.php"
	),
	"Updater"	=>	array(
		"name"		=>	"Updater",
		"path"		=>	"update/Updater.php"
	),
	"updateCheck"	=>	array(
		"name"		=>	"Update Check",
		"path"		=>	"update/updateCheck.php"
	),
	"updateInProgress"	=>	array(
		"name"		=>	"Updat In Progress",
		"path"		=>	"update/updateInProgress.php"
	),
	"updateActionCheck"	=>	array(
		"name"		=>	"Update Action Check",
		"path"		=>	"update/updateActionCheck.php"
	),
);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Log-Hog | Edit Files</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once("../core/php/customCSS.php");?>
	<table width="100%">
		<tr>
			<td>
				<div id="leftCol" class="sidebarLeft">
					<div id="fixed">
	        			<h2 align="center" style="margin-top:0px;">
	        				<img onclick="window.location = './devTools.php'" src="<?php echo $localURL; ?>img/backArrow.png" width="50px" style="display: inline-block; margin-top: 10px; margin-bottom: -15px; cursor: pointer;" >
	        				Files
	        			</h2>        
	    			</div>
				    <div id="scrollable" style="color:black;">
				        <table style="font-size:135%" width="100%" align="center">
					        <tr>
					        	<tr>
						            <ul style="list-style: none; cursor: pointer; ">
						            	<?php foreach ($fileNameArray as $key => $value)
						            	{
						            		echo "<li style='padding-top: 15px; '><a id='".$key."Link' class='link documentLink' onclick='loadFile(\"".$value['path']."\",\"".$key."\")'>".$value['name']."</a></li>";
						            	}
										?>
						            </ul>
					            </th>
					        </tr>
						</table>
			    	</div>
				    <table width="100%">
				    	<tr height="1000px">
				    		<th>
				    		</th>
				    	</tr>
				    </table>
				</div>
			</td>
			<td id="rightCol">
				<form style="background-color: white;  word-wrap: break-word;" id="document">
				</form>
			</td>
		</tr>
	</table>
</body>
<?php

$value = json_encode(highlight_file('../local/'.$currentSelectedTheme.'/conf/config.php', true));

?>
<script type="text/javascript">

	$(document).ready(function()
	{
		var newValue = (<?php echo $value; ?>);
		showFile(newValue, "LocalConfig");

		var targetHeight = window.innerHeight - $("#fixed").outerHeight() - 10;
		$("#scrollable").outerHeight(targetHeight);

		var targetWidth = window.innerWidth - $("#leftCol").outerWidth() - 30;
		$("#rightCol").outerWidth(targetWidth);
		$("#document").outerWidth(targetWidth);
	});

	function loadFile(filepath, name)
	{
		var urlForSend = "../core/php/returnFileContents.php?format=json";
		var data = {file: "../../"+filepath};
		$.ajax(
		{
			url: urlForSend,
			data,
			name,
			type: "POST",
			success(data)
			{
				showFile(data, this.name)
			},
			error(data, data2)
			{
				console.log(data);
				console.log(data2);
			},
			complete()
			{
				console.log("Fin");
			}
		});
	}

	function showFile(data, name)
	{
		$(".documentLink").removeClass("active");
		$("#"+name+"Link").addClass("active");
		document.getElementById("document").innerHTML = data;
	}

</script>
</html>