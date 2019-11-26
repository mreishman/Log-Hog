<?php
require_once("class/core.php");
$core = new core();
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
$varToIndexDir = $core->baseURL();
require_once($varToIndexDir."core/php/class/core.php");
$core = new core();
require_once($varToIndexDir."core/php/class/vars.php");
$vars = new vars();


$globalConfig = array();
if(file_exists($varToIndexDir.'local/conf/globalConfig.php'))
{
	require_once($varToIndexDir.'local/conf/globalConfig.php');
}
require_once($varToIndexDir.'core/conf/globalConfig.php');

$response = true;

foreach ($defaultGlobalConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		if(array_key_exists($key, $globalConfig))
		{
			if($_POST[$key] != $globalConfig[$key])
			{
				$response = false;
				break;
			}
		}
		else
		{
			if($_POST[$key] != $value)
			{
				$response = false;
				break;
			}
		}

	}
}

echo json_encode($response);