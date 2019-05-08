<?php

class upgrade extends core
{
	function upgradeConfig($newSaveStuff = array())
	{
		if(!is_array($newSaveStuff))
		{
			$newSaveStuff = array(
				"configVersion" => (Int)$newSaveStuff
			);
		}
		$baseBaseUrl = $this->baseURL();
		$baseUrl = $baseBaseUrl."local/";
		include($baseUrl.'layout.php');
		$baseUrl .= $currentSelectedTheme."/";
		include($baseUrl.'conf/config.php');
		include($baseBaseUrl.'core/conf/config.php');
		$currentTheme = $this->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
		{
			include($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
		}
		else
		{
			include($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.php");
		}
		include($baseBaseUrl.'core/php/loadVars.php');

		$fileName = ''.$baseUrl.'conf/config.php';
		$newInfoForConfig = "<?php
			$"."config = array(
			";
		foreach ($defaultConfig as $key => $value)
		{
			if(isset($newSaveStuff[$key]))
			{
				$newInfoForConfig .= $this->putIntoCorrectFormat($key, $newSaveStuff[$key], $value);
			}
			elseif(
				$$key !== $defaultConfig[$key] &&
				(
					!isset($themeDefaultSettings) ||
					isset($themeDefaultSettings) && !array_key_exists($key, $themeDefaultSettings) ||
					isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
				)
				||
				$$key === $defaultConfig[$key] && isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
				||
				isset($arrayOfCustomConfig[$key])
			)
			{
				$newInfoForConfig .= $this->putIntoCorrectFormat($key, $$key, $value);
			}
		}
		$newInfoForConfig .= "
			);
		?>";
		if(file_exists($fileName))
		{
			unlink($fileName);
		}
		file_put_contents($fileName, $newInfoForConfig);
	}
}