<?php


$writtenTextTofile = "<?php
	$"."setupProcess = '".$_POST['status']."';
	?>
";



file_put_contents("setupProcessFile.php", $writtenTextTofile);  

echo json_encode($_POST['status']);

?>