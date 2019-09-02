<?php

class vars
{
	public function forEachAddVars($variable)
	{
		$returnText = "array(";
		foreach ($variable as $key => $value)
		{
			$returnText .= " '".$key."' => ";
			if(is_array($value) || is_object($value))
			{
				$returnText .= $this->forEachAddVars($value);
			}
			else
			{
				$returnText .= "'".$value."',";
			}
		}
		$returnText .= "),";
		return $returnText;
	}

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

	public function escapeTheEscapes($stringToEscape)
	{
		return implode("\\\\", explode("\\", $stringToEscape));
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