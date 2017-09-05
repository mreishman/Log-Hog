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



$customCSS = "
<style type=\"text/css\">
#menu a, #menu2 a, .link, .linkSmall, .context-menu{
	background-color: ".$currentSelectedThemeColorValues[0].";
}
progress {
color: ".$currentSelectedThemeColorValues[0].";
}

body{
	background: ".$backgroundColor.";
}

/* Firefox */
progress::-moz-progress-bar { 
    background: ".$currentSelectedThemeColorValues[0].";  
}

/* Chrome */
progress::-webkit-progress-value {
    background: ".$currentSelectedThemeColorValues[0].";
}
</style>";
echo $customCSS;
?>