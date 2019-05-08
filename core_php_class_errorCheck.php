<?php
class errorCheck extends core
{

	public function checkIfFilesAreReadable($arrayOfFiles, $urlPath, $currentFile)
	{
		$cIFAReBaseUrl = $this->baseURL();
		foreach ($arrayOfFiles as $file)
		{
			if(!is_readable($cIFAReBaseUrl.$file))
			{
				$this->echoErrorJavaScript($urlPath, $file." could not be read from ".$currentFile, 1072);
			}
		}
	}

	public function checkIfFilesAreWritable($arrayOfFiles, $urlPath, $currentFile)
	{
		$cIFAWBaseUrl = $this->baseURL();
		foreach ($arrayOfFiles as $file)
		{
			if(!is_writable($cIFAWBaseUrl.$file))
			{
				$this->echoErrorJavaScript($urlPath, $file." could not be written to from ".$currentFile, 1073);
			}
		}
	}

	public function checkIfFilesExist($arrayOfFiles, $urlPath, $currentFile)
	{
		$cIFATBaseUrl = $this->baseURL();
		foreach ($arrayOfFiles as $file)
		{
			if(!file_exists($cIFATBaseUrl.$file))
			{
				$this->echoErrorJavaScript($urlPath, $file." is not accessable from ".$currentFile, 1074);
			}
		}
	}
}