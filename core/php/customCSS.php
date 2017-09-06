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

?>
<style type="text/css">
#menu a, #menu2 a, .link, .linkSmall, .context-menu
{
	background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
}

progress
{
	color: <?php echo $currentSelectedThemeColorValues[0]?>;
}

body
{
	background: <?php echo $backgroundColor?>;
	color: <?php echo $mainFontColor; ?>
}

#menu
{
	background: <?php echo $backgroundHeaderColor?>;
}

/* Firefox */
progress::-moz-progress-bar
{ 
    background: <?php echo $currentSelectedThemeColorValues[0]?>;  
}

/* Chrome */
progress::-webkit-progress-value
{
    background: <?php echo $currentSelectedThemeColorValues[0]?>;
}
</style>
