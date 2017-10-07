<?php
sleep(3);
function forEachAddVars($variable)
{
	$returnText = "array(";
	foreach ($variable as $key => $value)
	{
		$returnText .= " '".$key."' => ";
		if(is_array($value) || is_object($value))
		{
			$returnText .= forEachAddVars($value);
		}
		else
		{
			$returnText .= "'".$value."',";
		}
	}
	$returnText .= "),";
	return $returnText;
}

$baseUrl = "../../../../core/";
if(file_exists('../../../../local/layout.php'))
{
	$baseUrl = "../../../../local/";
	//there is custom information, use this
	require_once('../../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../../../../core/conf/config.php');


foreach ($defaultConfig as $key => $value)
{
	if(array_key_exists($key, $config))
	{
		$$key = $config[$key];
	}
	else
	{
		$$key = $value;
	}
}

$folderColorArrays	= array(
	'theme-default-1'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#EA7AF4',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#B43E8F",
				'fontColor'		=> "#FFFFFF"
				),
			'main-3'		=> array(
				'background'	=> "#6200B3",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#3B0086",
				'fontColor'		=> "#FFFFFF"
				),
			'main-5'		=> array(
				'background'	=> "#290628",
				'fontColor'		=> "#FFFFFF"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-2'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#6B8E23',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#556B2F",
				'fontColor'		=> "#FFFFFF"
				),
			'main-3'		=> array(
				'background'	=> "#2E8B57",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#3CB371",
				'fontColor'		=> "#FFFFFF"
				),
			'main-5'		=> array(
				'background'	=> "#8FBC8F",
				'fontColor'		=> "#FFFFFF"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-3'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#03256C',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#2541B2",
				'fontColor'		=> "#FFFFFF"
				),
			'main-3'		=> array(
				'background'	=> "#1768AC",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#06BEE1",
				'fontColor'		=> '#FFFFFF'
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-4'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#012A36',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#29274C",
				'fontColor'		=> "#FFFFFF"
				),
			'main-3'		=> array(
				'background'	=> "#7E52A0",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#D295BF",
				'fontColor'		=> "#000000"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-5'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#69626D',
				'fontColor'		=> '#000000'
				),
			'main-2'		=> array(
				'background'	=> "#BCAF9C",
				'fontColor'		=> "#000000"
				),
			'main-3'		=> array(
				'background'	=> "#CBBEB3",
				'fontColor'		=> '#000000'
				),
			'main-4'		=> array(
				'background'	=> "#D9BDC5",
				'fontColor'		=> "#000000"
				),
			'main-5'		=> array(
				'background'	=> "#E8C7DE",
				'fontColor'		=> "#000000"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-6'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#388659',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#52AA5E",
				'fontColor'		=> "#FFFFFF"
				),
			'main-3'		=> array(
				'background'	=> "#52AA8A",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#3AAED8",
				'fontColor'		=> "#FFFFFF"
				),
			'main-5'		=> array(
				'background'	=> "#2BD9FE",
				'fontColor'		=> "#FFFFFF"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-7'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#C4F1BE',
				'fontColor'		=> '#000000'
				),
			'main-2'		=> array(
				'background'	=> "#A2C3A4",
				'fontColor'		=> "#000000"
				),
			'main-3'		=> array(
				'background'	=> "#869D96",
				'fontColor'		=> '#FFFFFF'
				),
			'main-4'		=> array(
				'background'	=> "#525B76",
				'fontColor'		=> "#FFFFFF"
				),
			'main-5'		=> array(
				'background'	=> "#201E50",
				'fontColor'		=> "#FFFFFF"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-8'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#1B2F33',
				'fontColor'		=> '#656565'
				),
			'main-2'		=> array(
				'background'	=> "#28502E",
				'fontColor'		=> "#656565"
				),
			'main-3'		=> array(
				'background'	=> "#2D421B",
				'fontColor'		=> '#656565'
				),
			'main-4'		=> array(
				'background'	=> "#3F3324",
				'fontColor'		=> "#656565"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFFFFF',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#EF3054',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#F7A0B1',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-9'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#79B791',
				'fontColor'		=> '#FFFFFF'
				),
			'main-2'		=> array(
				'background'	=> "#ABD1B5",
				'fontColor'		=> "#000000"
				),
			'main-3'		=> array(
				'background'	=> "#2D421B",
				'fontColor'		=> '#FFFFFF'
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#EDF4ED',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#301014',
				'fontColor'		=> '#FFFFFF'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FF5468',
				'fontColor'		=> '#000000'
				)
			)
		),
	'theme-default-10'	=> array(
		'main' 		=> array(
			'main-1'		=> array(
				'background'	=> '#E2D4B7',
				'fontColor'		=> '#000000'
				),
			'main-2'		=> array(
				'background'	=> "#9C9583",
				'fontColor'		=> "#000000"
				),
			'main-3'		=> array(
				'background'	=> "#A1A499",
				'fontColor'		=> '#000000'
				),
			'main-4'		=> array(
				'background'	=> "#B0BBBF",
				'fontColor'		=> "#000000"
				),
			'main-5'		=> array(
				'background'	=> "#CADBC8",
				'fontColor'		=> "#000000"
				)
			),
		'highlight' => array(
			'highlight-1'	=> array(
				'background'	=> '#FFEECE',
				'fontColor'		=> '#000000'
				)
			),
		'active'	=> array(
			'active-1'		=> array(
				'background'	=> '#912A2C',
				'fontColor'		=> '#000000'
				)
			),
		'highlightActive'	=> array(
			'highlightActive-1'	=> array(
				'background'	=> '#FFDDFF',
				'fontColor'		=> '#000000'
				)
			)
		),
	);



foreach ($folderColorArrays as $key => $value)
{
	if($key == $currentFolderColorTheme)
	{
		$currentSelectedThemeColorValues = $value;
	}
}


$arrayWatchList = "";

$numberOfRows = count($watchList);
$i = 0;
foreach ($watchList as $key => $value)
{
	$i++;
	$arrayWatchList .= "'".$key."' => '".$value."'";
	if($i != $numberOfRows)
	{
		$arrayWatchList .= ",";
	}
}

$watchList = $arrayWatchList;

$popupSettingsArraySave = "";
if($popupWarnings == "all")
{
	$popupSettingsArraySave = "
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true',
		'versionCheck'	=> 'true'
		";
}
elseif($popupWarnings == "none")
{
	$popupSettingsArraySave = "
		'saveSettings'	=>	'false',
		'blankFolder'	=>	'false',
		'deleteLog'	=>	'false',
		'removeFolder'	=> 	'false',
		'versionCheck'	=> 'false'
		";
}
else
{
	$popupSettingsArraySave = "";
	foreach ($popupSettingsArray as $key => $value)
	{
		$popupSettingsArraySave .= "'".$key."'	=>	'".$value."',";
	}
}
$popupSettingsArray = $popupSettingsArraySave;

$folderColorArraysSave = "";
foreach ($folderColorArrays as $key => $value)
{
	$folderColorArraysSave .= "'".$key."'	=>	";
	$folderColorArraysSave .= forEachAddVars($value);
}
$folderColorArrays = $folderColorArraysSave;	

$fileName = ''.$baseUrl.'conf/config.php';

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

file_put_contents($fileName, $newInfoForConfig);	
sleep(3);
echo json_encode(true);

//TRUE for no check, or filename / path for check
?>
