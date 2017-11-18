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
body
{
	background: <?php echo $backgroundColor?>;
	color: <?php echo $mainFontColor; ?>;
	font-family: <?php echo $fontFamily;?>;
}

#log, #firstLoad
{
	color: <?php echo $logFontColor; ?>;
}

<?php if($invertMenuImages === 'true'): ?>

.menuImage
{
	filter: invert(100%);
}

<?php endif; ?>
</style>
