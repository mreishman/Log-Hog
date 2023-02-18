<?php

class upgrade extends core
{
	protected $session = null;

	function upgradeConfig($newSaveStuff = array())
	{
		if(!is_array($newSaveStuff))
		{
			$newSaveStuff = array(
				"configVersion" => (Int)$newSaveStuff
			);
		}
		$baseBaseUrl = $this->baseURL();
		if($this->session === null)
		{
			include($baseBaseUrl.'core/php/class/session.php');
			$this->session = new session();
		}
		$baseUrl = $baseBaseUrl."local/";
		$currentSelectedTheme = $this->session->returnCurrentSelectedTheme();
		$baseUrl .= $currentSelectedTheme."/";
		include($baseUrl.'conf/config.php');
		include($baseBaseUrl.'core/conf/config.php');
		$currentTheme = $this->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir($baseBaseUrl.'local/Themes/'.$currentTheme))
		{
			include($baseBaseUrl.'local/Themes/'.$currentTheme."/defaultSetting.php");
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

	public function globalConfig($newSaveStuff = array()) {

		$baseBaseUrl = $this->baseURL();
		if($this->session === null)
		{
			include($baseBaseUrl.'core/php/class/session.php');
			$this->session = new session();
		}
		$globalConfig = array();
		if(file_exists($baseBaseUrl .'local/conf/globalConfig.php'))
		{
			include($baseBaseUrl .'local/conf/globalConfig.php');
			// Ok if it doesn't exist, user might have deleted to reset settings or something?
		}

		if (!file_exists($baseBaseUrl ."core/conf/globalConfig.php") || !is_readable($baseBaseUrl ."core/conf/globalConfig.php"))
		{
			echo json_encode(8);
			exit();
		}
		include($baseBaseUrl .'core/conf/globalConfig.php');
		$baseUrl = $baseBaseUrl."local/";
		$currentSelectedTheme = $this->session->returnCurrentSelectedTheme();
		$baseUrl .= $currentSelectedTheme."/";
		include($baseUrl.'conf/config.php');
		include($baseBaseUrl.'core/conf/config.php');
		$currentTheme = $this->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir($baseBaseUrl.'local/Themes/'.$currentTheme))
		{
			include($baseBaseUrl.'local/Themes/'.$currentTheme."/defaultSetting.php");
		}
		else
		{
			include($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.php");
		}
		include($baseBaseUrl.'core/php/loadVars.php');

		$fileName = $baseBaseUrl .'local/conf/globalConfig.php';

		$newInfoForConfig = "<?php
			$"."globalConfig = array(
			";
		foreach ($defaultGlobalConfig as $key => $value)
		{
			if(isset($newSaveStuff[$key]))
			{
				$newInfoForConfig .= $this->putIntoCorrectFormat($key, $newSaveStuff[$key], $value);
			}
			else
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

	public function getCurrentSelectedTheme()
	{
		if($this->session === null)
		{
			$baseBaseUrl = $this->baseURL();
			include($baseBaseUrl.'core/php/class/session.php');
			$this->session = new session();
		}
		return $this->session->returnCurrentSelectedThemeAjax();
	}
}