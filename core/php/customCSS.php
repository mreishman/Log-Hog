<?php
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
#menu a, #menu2 a, .link, .linkSmall
{
	background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
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

body
{
	background: <?php echo $backgroundColor?>;
	color: <?php echo $mainFontColor; ?>;
	font-family: <?php echo $fontFamily;?>;
}

.log, #firstLoad
{
	color: <?php echo $logFontColor; ?>;
}

#menu
{
	background: <?php echo $backgroundHeaderColor?>;
	color: <?php echo $currentSelectedThemeColorValues['main']['main-1']['fontColor']?>;
}

/* Firefox */
progress::-moz-progress-bar
{ 
    background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;  
}

/* Chrome */
progress::-webkit-progress-value
{
    background: <?php echo $currentSelectedThemeColorValues['main']['main-1']['background']?>;
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

.currentWindowNum
{
	display: none;
}

.currentWindowNumSelected
{
	display: none;
}

<?php else: ?>

.currentWindowNum
{
	text-align: center;
	color: <?php echo $currentSelectedThemeColorValues['highlight']['highlight-1']['fontColor']?>;
}
<?php endif; ?>

.highlight
{
	background-color: <?php echo $highlightColorBG; ?>;
	color: <?php echo $highlightColorFont; ?>;
}

.newLine
{
	background-color: <?php echo $highlightColorBG; ?>;
	color: <?php echo $highlightColorFont; ?>;
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

</style>
