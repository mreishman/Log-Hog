<?php
if(!function_exists('baseURL'))
{
	require_once("commonFunctions.php");
}
$baseURLToMain =  baseURL();

$baseUrl = $baseURLToMain."core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = $baseURLToMain."local/";
	//there is custom information, use this
	require_once($baseURLToMain.'local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once($baseURLToMain.'core/conf/config.php');
require_once($baseURLToMain.'core/php/configStatic.php');
require_once($baseURLToMain.'core/php/loadVars.php');

$windowDisplayConfig = explode("x", $windowConfig);

?>
<style type="text/css">

.log, #firstLoad, .log table tr:not(.highlight):not(.newLine) td:not(.highlight):not(.newLine)
{
	color: <?php echo $logFontColor; ?>;
}


.log, #firstLoad, .log table tr td
{
	font-size: <?php echo $logFontSize; ?>%;
}

.highlight, .highlight td
{
	background-color: <?php echo $highlightColorBG; ?>;
	color: <?php echo $highlightColorFont; ?>;
}

.newLine
{
	background-color: <?php echo $highlightNewColorBG; ?>;
	color: <?php echo $highlightNewColorFont; ?>;
}

#menu, #menu2
{
	max-height: <?php echo $maxHeightLogTabs; ?>px;
}

<?php if($logMenuLocation === "top"):

/* nothing changes */

elseif($logMenuLocation === "bottom"): ?>

#menu
{
	bottom: 0;
}

<?php elseif($logMenuLocation === "left"): ?>

#menu
{
	bottom: 0;
	width: 200px;
	max-height: none;
	word-break: break-all;
}

#main
{
	padding-left: 200px;
}

#menu a
{
	display: block;
}

<?php elseif($logMenuLocation === "right"): ?>

#menu
{
	bottom: 0;
	right: 0;
	width: 200px;
	max-height: none;
	word-break: break-all;
}

#main
{
	padding-right: 200px;
}

#menu a
{
	display: block;
}

<?php endif; ?>

</style>
