<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/conf/globalConfig.php');
require_once('../local/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/Themes/'.$currentTheme))
{
	require_once('../local/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Log-Hog | Edit Files</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScripts(
		array(
			array(
				"filePath"		=> "../core/js/jquery.js",
				"baseFilePath"	=> "core/js/jquery.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/editFiles.js",
				"baseFilePath"	=> "core/js/editFiles.js",
				"default"		=> $configStatic["version"]
			)
		)
	); ?>
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
	        				echo $core->generateImage(
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
						            	<?php
						            	$jsonFiles = file_get_contents("core/json/listOfFiles.json");
										$fileNameArray = json_decode($jsonFiles, true);
						            	foreach ($fileNameArray as $key => $value)
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
							<th></th>
				    	</tr>
				    </table>
				</div>
			</td>
			<td id="rightCol">
				<form style="background-color: white;  word-wrap: break-word;" id="document"></form>
			</td>
		</tr>
	</table>
</body>
<script type="text/javascript">
	var newValue = (<?php echo json_encode(highlight_file('../local/'.$currentSelectedTheme.'/conf/config.php', true)); ?>);
</script>
</html>