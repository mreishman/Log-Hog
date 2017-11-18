<?php
require_once("commonFunctions.php");

$arrayOfArrays = array();
$arrayOfFinalTests = array();
$filterInclude = array();
$filterExclude = array();

$groupsIncludeArray = $_POST['groupsInclude'];
if($groupsIncludeArray == "empty array")
{
	$groupsIncludeArray = array();
}
$groupsExcludeArray = $_POST['groupsExclude'];
if($groupsExcludeArray == "empty array")
{
	$groupsExcludeArray = array();
}
$file = $_POST['file'];

foreach ($groupsIncludeArray as $key => $value)
{
	array_push($filterInclude, $value["name"]);
}
foreach ($groupsExcludeArray as $key => $value)
{
	array_push($filterExclude, $value["name"]);
}

$testListOfIncludeArray = getAllTestsFromGroup($file, $filterInclude);
$testListOfExcludeArray = getAllTestsFromGroup($file, $filterExclude);

$count = 0;

foreach ($testListOfIncludeArray as $test)
{
	if(!in_array($test, $testListOfExcludeArray))
	{
		array_push($arrayOfFinalTests, $test);
		$count++;
	}
}
$arrayOfArrays["testList"] = $arrayOfFinalTests;
$arrayOfArrays["testListCount"] = $count;

echo json_encode($arrayOfArrays);