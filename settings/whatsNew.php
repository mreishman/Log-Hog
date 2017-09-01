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
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link href="../core/template/lightbox.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/lightbox-2.6.min.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main" > 
		<h1 style="width: 100%; text-align: center; " >You are on version <?php echo $configStatic['version'];?>!</h1>
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

				<tr>
				<th colspan="2" style="border-bottom: 1px solid white; padding: 10px">
					2.3
				</th>
				</tr>
				<!-- 2.3 -->

				<tr>
				<td>
					<b>Monitor!</b>
					<ul>
						<li>
						CPU usage
						</li>
						<li>
						Ram / swap usage
						</li>
						<li>
						Disk usage / IO
						</li>
						<li>
						PHP User time used / system time used
						</li>
						<li>
						Network Interface receive / transmit
						</li>
						<li>
						Shows list of processes
						</li>
					</ul>
				</td>
				<td>
					<a href="../core/img/2.3-1.png" data-lightbox="2.3" ><img src="../core/img/2.3-1.png" style="width: 45%;"></a>
					<a href="../core/img/2.3-2.png" data-lightbox="2.3" ><img src="../core/img/2.3-2.png" style="width: 45%;"></a>
				</td>
				</tr>


				<!-- 2.2 -->




				<!-- 2.1 -->



				<!-- 2.0 -->

			</table>
	
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
</body>
<script src="../core/js/settings.js"></script>
<script src="../core/js/settingsMain.js"></script>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}
</script>