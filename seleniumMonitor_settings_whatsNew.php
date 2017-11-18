<?php
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
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/commonFunctions.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link href="../core/template/lightbox.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/lightbox-2.6.min.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main" > 
		<h1 style="width: 100%; text-align: center;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black; " >You are on version <?php echo $configStatic['version'];?>!</h1>
		<div class="settingsDiv" >
			<table width="100%;">
				<tr>
					<td width="25%" >
					</td>
					<td width="75%">
					</td>
				</tr>

				<tr>
					<td>
					</td>
					<td>
					</td>
				</tr>

			</table>
	
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>