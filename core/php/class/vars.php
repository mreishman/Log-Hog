<?php

class vars
{
	public function checkIfShouldLoad($loadCustomConfigVars, $key)
	{
		if(!$loadCustomConfigVars)
		{
			$type = $_POST['resetConfigValuesBackToDefault'];
			if($type === "all")
			{
				return false;
			}

			if($type === "justWatch")
			{
				if($key === "watchList")
				{
					return false;
				}
				return true;
			}

			if($type === "allButWatch")
			{
				if($key !== "watchList")
				{
					return false;
				}
				return true;
			}
		}
		return true;
	}

	public function checkIfURIContains($arrayOfChecks)
	{
		$URI = $_SERVER['REQUEST_URI'];
		foreach ($arrayOfChecks as $checkValue)
		{
			if(strpos($URI, $checkValue) !== false)
			{
				return true;
			}
		}
		return false;
	}
}