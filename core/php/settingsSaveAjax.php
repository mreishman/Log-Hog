<?php

$baseUrl = "../../local/";
//there is custom information, use this
require_once('../../local/layout.php');
$baseUrl .= $currentSelectedTheme."/";

require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('loadVars.php');
if($backupNumConfigEnabled === "true")
{
	for ($i=$backupNumConfig; $i > 0; $i--)
	{
		$addonNum = "";
		if($i !== 1)
		{
			$addonNum = $i-1;
		}
		$fileNameOld = ''.$baseUrl.'conf/config'.$addonNum.'.php';
		$fileNameNew = ''.$baseUrl.'conf/config'.$i.'.php';
		if (file_exists($fileNameOld))
		{
			try
			{
				rename($fileNameOld, $fileNameNew);
			}
			catch (Exception $e)
			{
				echo json_encode(6);
				exit();
			}
			
		}
	}
}

	$fileName = ''.$baseUrl.'conf/config.php';

	//Don't forget to update Normal version

	$newInfoForConfig = "<?php
		$"."config = array(
		";
	foreach ($defaultConfig as $key => $value)
	{
		if(is_string($value))
		{
			$newInfoForConfig .= "
			'".$key."' => '".$$key."',
		";
		}
		elseif(is_array($value))
		{
			$newInfoForConfig .= "
			'".$key."' => array(".$$key."),
		";
		}
		else
		{
			$newInfoForConfig .= "
			'".$key."' => ".$$key.",
		";
		}
	}
	$newInfoForConfig .= "
		);
	?>";

	//Don't forget to update Normal version

	if(is_writable($baseUrl."conf/"))
	{
		if(file_exists($fileName))
		{
			if(!is_writable($fileName))
			{
				echo json_encode(4);
				exit();
			}
		}
		try
		{
			file_put_contents($fileName, $newInfoForConfig);
		}
		catch (Exception $e)
		{
			echo json_encode(5);
			exit();
		}
		
		echo json_encode(true);
		exit();
	}
	echo json_encode(3)
	exit();
?>