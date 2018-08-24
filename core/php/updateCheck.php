<?php
if(array_key_exists('updateNoticeMeter', $config))
{
	$updateNoticeMeter = $config['updateNoticeMeter'];
}
else
{
	$updateNoticeMeter = $defaultConfig['updateNoticeMeter'];
}


$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		$compareTo = intval($newestVersion[$i]);
		$compareFrom = intval($version[$i]);
		if($i == 0)
		{
			if($compareTo > $compareFrom)
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($compareTo < $compareFrom)
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($compareTo > $compareFrom)
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($compareTo < $compareFrom)
			{
				break;
			}
		}
		else
		{
			if($compareTo > $compareFrom)
			{
				if($updateNoticeMeter == "every")
				{
					$levelOfUpdate = 1;
				}
				break;
			}
			elseif($compareTo < $compareFrom)
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}