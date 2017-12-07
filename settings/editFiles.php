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
				<div class="sidebarLeft">
					<div id="fixed">
	        			<h2 align="center" style="margin-top:0px;">Files</h2>        
	    			</div>
				    <div id="scrollable" style="color:black;">
				        <table style="font-size:135%" width="100%" align="center">
					        <tr>
					        	<tr>
						            <ul style="list-style: none; cursor: pointer;">
										<li> 
					                    	 <a>File Name</a>
					                    </li>
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
			<td width="85%">
			</td>
		</tr>
	</table>
</body>
</html>