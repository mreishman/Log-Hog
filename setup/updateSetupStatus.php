<?php
$writtenTextTofile = "<?php
	$"."setupProcess = '".$_POST['status']."';
	?>
";
if(file_exists("setupProcessFile.php"))
{
	unlink("setupProcessFile.php");
}
file_put_contents("setupProcessFile.php", $writtenTextTofile);
echo json_encode($_POST['status']);