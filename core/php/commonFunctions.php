<?php

function baseURL()
{
	$tmpFuncBaseURL = "";
	$boolBaseURL = file_exists($tmpFuncBaseURL."error.php");
	while(!$boolBaseURL)
	{
		$tmpFuncBaseURL .= "../";
		$boolBaseURL = file_exists($tmpFuncBaseURL."error.php");
	}
	return $tmpFuncBaseURL;
}