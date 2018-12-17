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
#menu a, #menu2 a, .link, .linkSmall, .menu a
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

#menu2
{
	background: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['fontColor']?>;
}

<?php
$count = 0;
foreach ($currentSelectedThemeColorValues['main'] as $value):
	$count++;
	?>

	#menu .buttonColor<?php echo $count;?>
	{
		color: <?php echo $value['fontColor'];?>;
		background: <?php echo $value['background'];?>;
	}

<?php endforeach; ?>

#menu a:hover, #menu a.active, #menu2 a:hover, #menu2 a.active, .link:hover, .linkSmall:hover, .settingsHeader button:hover, .sidebarLeft .active {
	color: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['fontColor']?>;
	background: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['background']?>;
}

#menu a.updated {
	background: <?php echo $currentSelectedThemeColorValues['active']['active-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['active']['active-1']['fontColor']?>; 
}

#menu a.updated:hover {
	background: <?php echo $currentSelectedThemeColorValues['highlightActive']['highlightActive-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['highlightActive']['highlightActive-1']['fontColor']?>; 
}

progress
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
}

body, #main
{
	background: <?php echo $backgroundColor?>;
	color: <?php echo $mainFontColor; ?>;
	font-family: <?php echo $fontFamily;?>;
	filter: brightness(<?php echo $overallBrightness; ?>%);
}

#menu, .backgroundForMenus
{
	background: <?php echo $backgroundHeaderColor?>;
	color: <?php echo $mainFontColor; ?>;
}

/* Firefox */
progress::-moz-progress-bar
{
    background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

/* Chrome */
progress::-webkit-progress-bar
{
    background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
}

progress::-webkit-progress-value
{
    background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}


.selectDiv
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
}

.selectDiv select
{
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

div.sidebarLeft
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

div#fixed
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-2']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-2']['fontColor']?>;
}

<?php if($invertMenuImages === 'true'): ?>

.menuImage
{
	filter: invert(100%);
}

<?php endif;

if(!($windowDisplayConfig[0] > 1 || $windowDisplayConfig[1] > 1)): ?>

.pinWindowContainer, .currentWindowNumSelected, .currentWindowNum
{
	display: none;
}

<?php endif; ?>

.currentWindowNum
{
	text-align: center;
	color: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['fontColor']?>;
}


/* width */
::-webkit-scrollbar
{
	width: 10px;
}

/* Track */
::-webkit-scrollbar-track
{
	<?php echo $scrollBarTrack; ?>
}

/* Handle */
::-webkit-scrollbar-thumb
{
	<?php echo $scrollBarHandle; ?>
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover
{
	<?php echo $scrollBarHandleHover; ?>
}

.addBorder
{
	border: 1px solid <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

.addBorderBottom
{
	border-bottom: 1px solid <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

.addBorderTop
{
	border-top: 1px solid <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

.addBorderLeft
{
	border-left: 1px solid <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

.addBorderRight
{
	border-right: 1px solid <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

.addBackground
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

</style>
