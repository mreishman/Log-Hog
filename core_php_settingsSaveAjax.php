<?php

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

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
			rename($fileNameOld, $fileNameNew);
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

	file_put_contents($fileName, $newInfoForConfig);
	echo json_encode(true);
	exit();
?>