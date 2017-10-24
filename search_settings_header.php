<?php
require_once('../setup/setupProcessFile.php');
$URI = $_SERVER['REQUEST_URI'];
require_once("../core/php/customCSS.php");
echo loadSentryData($sendCrashInfoJS); ?>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>


<?php require_once("../core/php/template/menu.php"); ?>

<?php 

$baseUrlImages = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrlImages = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrlImages .= $currentSelectedTheme."/";
}

?>

<script type="text/javascript">
	
	var baseUrl = "<?php echo $baseUrlImages;?>";

</script>
