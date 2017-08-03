<?php

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";        
}

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php'); 
}
else
{
	$config = array();
}
require_once($varToIndexDir.'core/conf/config.php');

$response = true;

foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		if($_POST[$key] != $config[$key])
		{
			$response = false;
			break;
		}
	}
}

echo json_encode($response);
?>