<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
require_once('../core/php/template/listOfFiles.php');

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
	        				<a onclick="window.location = './devTools.php'" >
	        				<?php
	        				echo generateImage(
									$arrayOfImages["backArrow"],
									array(
										"width"		=>	"50px",
										"srcModifier"	=>	"../",
										"style"			=>	"display: inline-block; margin-top: 10px; margin-bottom: -15px; cursor: pointer;"
									)
								);
	        				?>
	        				</a>
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