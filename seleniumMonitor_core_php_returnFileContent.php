<?php
require_once("commonFunctions.php");
$file = file($_POST['file']);
$arrayOfArrays = array();
$arrayOfGroups = array();
$arrayOfTests = array();


for ($i=0; $i < count($file); $i++)
{ 
	if(strpos($file[$i], "@group") !== false)
	{
		if(strpos($file[$i], "//") === false)
		{
			$line = filterGroupname($file[$i]);
			if(!in_array($line, $arrayOfGroups))
			{
				array_push($arrayOfGroups, $line);
			}
		}
	}
}

for ($i=0; $i < count($file); $i++)
{ 
	if(strpos($file[$i], "public function") !== false)
	{
		if(strpos($file[$i], "test") !== false)
		{
			if(strpos($file[$i], "//") === false)
			{
				$line = filterFunctionName($file[$i]);
				if(!in_array($line, $arrayOfTests))
				{
					array_push($arrayOfTests, $line);
				}
			}
		}
	}
}

$arrayOfArrays['arrayOfGroups'] = $arrayOfGroups;
$arrayOfArrays['arrayOfTests'] = $arrayOfTests;

echo json_encode($arrayOfArrays);