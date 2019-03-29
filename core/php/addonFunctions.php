<?php
class addonFunctions
{

	private function baseURL()
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

	public function checkForStatusInstall($manualReturn, $relBase)
	{
		$baseBaseUrl = $this->baseURL();
		if($manualReturn != "")
		{
			return array(
				'local'	=> false,
				'loc'	=> $manualReturn
			);
		}
		elseif (is_dir($baseBaseUrl."../status"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../status/"
			);
		}
		elseif (is_dir($baseBaseUrl."../Status"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../Status/"
			);
		}
		return array(
			'local'	=> false,
			'loc'	=> false
		);
	}

	public function checkForMonitorInstall($manualReturn, $relBase)
	{
		$baseBaseUrl = $this->baseURL();
		if($manualReturn != "")
		{
			return array(
				'local'	=> false,
				'loc'	=> $manualReturn
			);
		}
		elseif(is_file($baseBaseUrl."monitor/index.php"))
		{
			return array(
				'local'	=> true,
				'loc'	=> $relBase."monitor"
			);
		}
		elseif (is_dir($baseBaseUrl."../monitor"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../monitor/"
			);
		}
		elseif (is_dir($baseBaseUrl."../Monitor"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../Monitor/"
			);
		}
		return array(
			'local'	=> false,
			'loc'	=> false
		);
	}

	public function checkForSearchInstall($manualReturn, $relBase)
	{
		$baseBaseUrl = $this->baseURL();
		if($manualReturn != "")
		{
			return array(
				'local'	=> false,
				'loc'	=> $manualReturn
			);
		}
		elseif(is_file($baseBaseUrl."search/index.php"))
		{
			return array(
				'local'	=> true,
				'loc'	=> $relBase."search/"
			);
		}
		elseif (is_dir($baseBaseUrl."../search"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../search/"
			);
		}
		elseif (is_dir($baseBaseUrl."../Search"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../Search/"
			);
		}
		return array(
			'local'	=> false,
			'loc'	=> false
		);
	}

	public function checkForSeleniumMonitorInstall($manualReturn, $relBase)
	{
		$baseBaseUrl = $this->baseURL();
		if($manualReturn != "")
		{
			return array(
				'local'	=> false,
				'loc'	=> $manualReturn
			);
		}
		elseif(is_file($baseBaseUrl."seleniumMonitor/index.php"))
		{
			return array(
				'local'	=> true,
				'loc'	=> $relBase."seleniumMonitor/"
			);
		}
		elseif (is_dir($baseBaseUrl."../seleniumMonitor"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../seleniumMonitor/"
			);
		}
		elseif (is_dir($baseBaseUrl."../SeleniumMonitor"))
		{
			return array(
				'local'	=> false,
				'loc'	=> $relBase."../SeleniumMonitor/"
			);
		}
		return array(
			'local'	=> false,
			'loc'	=> false
		);
	}
}