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

.log, #firstLoad, .log table:not(.oneLogTable):not(.logCode) tr:not(.highlight):not(.newLine) td:not(.highlight):not(.newLine) , #settingsSideBar
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

.highlight .settingsDiv{
	background-color: rgba(0,0,0,0);
	border: 1px solid <?php echo $highlightColorFont; ?>;
}

.newLine
{
	background-color: <?php echo $highlightNewColorBG; ?>;
	color: <?php echo $highlightNewColorFont; ?>;
}

.newLine .settingsDiv{
	background-color: rgba(0,0,0,0);
	border: 1px solid <?php echo $highlightColorFont; ?>;
}

.logCode{
	background-color: <?php echo $logFormatFileBackground; ?>;
	border: 1px solid <?php echo $logFontColor; ?>;
	color: <?php echo $logFormatFileFontColor; ?>;
	padding: 10px 0;
	max-height: <?php echo $oneLogLogMaxHeight; ?>px;
	overflow: auto;
}

.log table:not(.oneLogTable):not(.logCode) tr:not(.highlight):not(.newLine) td:not(.highlight):not(.newLine) .logCode tr:not(.highlight):not(.newLine) td:not(.highlight):not(.newLine)
{
	color: <?php echo $logFormatFileFontColor; ?>;
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
<?php if ($allLogsVisible === "true"): ?>
#main
{
	padding-left: 200px;
}
<?php endif; ?>
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
<?php if ($allLogsVisible === "true"): ?>
#main
{
	padding-right: 200px;
}
<?php endif; ?>
#menu a
{
	display: block;
}

<?php endif; ?>

<?php if ($notificationInlineLocation === "center"): ?>
#inlineNotifications{
  left: 50%;
  margin-left: -250px;
}

<?php elseif ($notificationInlineLocation === "topLeft"): ?>
#inlineNotifications{
  left: 0;
}

<?php elseif ($notificationInlineLocation === "topRight"): ?>
#inlineNotifications{
  right: 0;
}

<?php elseif ($notificationInlineLocation === "bottomLeft"): ?>
#inlineNotifications{
  left: 0;
  bottom: 0;
}

<?php elseif ($notificationInlineLocation === "bottomRight"): ?>
#inlineNotifications{
  right: 0;
  bottom: 0;
}

<?php endif; ?>

@media only screen and (max-width: 500px) {
    #inlineNotifications{
    left: 0;
    right: 0;
    width: auto;
  }
}

.inlineNotificationsClass{
  border: 1px solid <?php echo $notificationInlineFontColor; ?>;
}

.inlineNotificationsClass , .inlineNotificationsClass td{
  background-color: <?php echo $notificationInlineBGColor; ?>;
  color: <?php echo $notificationInlineFontColor; ?>;
}

<?php if($notificationPreviewHideWidth === "true"): ?>
@media only screen and (max-width: 1000px) {
	.notificationPreviewLog{
		display: none;
	}
}
<?php endif; ?>

<?php if($oneLogCustomStyle === "true"): ?>
	#log .settingsDiv{
		background-color: <?php echo $oneLogColorBG; ?>;
	}

	.oneLogTable tr:not(.highlight):not(.newLine) td:not(.highlight):not(.newLine){
		color: <?php echo $oneLogColorFont; ?>;
	}
<?php endif; ?>

</style>
