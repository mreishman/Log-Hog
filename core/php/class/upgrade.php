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
		$config = settingsData::read($baseUrl.'conf/config.json', 'config');
		$defaultConfig = settingsData::defaults('config');
		$currentTheme = $this->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir($baseBaseUrl.'local/Themes/'.$currentTheme))
		{
			$themeDefaultSettings = settingsData::read($baseBaseUrl.'local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
		}
		else
		{
			$themeDefaultSettings = settingsData::read($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
		}
		include($baseBaseUrl.'core/php/loadVars.php');

		$fileName = ''.$baseUrl.'conf/config.json';
		$newInfoForConfig = [];
		foreach ($defaultConfig as $key => $value)
		{
			if(isset($newSaveStuff[$key]))
			{
				$newInfoForConfig[$key] = $newSaveStuff[$key];
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
				$newInfoForConfig[$key] = $$key;
			}
		}

		if (!settingsData::write($fileName, $newInfoForConfig)) {
			throw new RuntimeException("Could not save upgraded settings");
		}
	}

	public function globalConfig($newSaveStuff = array()) {

		$baseBaseUrl = $this->baseURL();
		if($this->session === null)
		{
			include($baseBaseUrl.'core/php/class/session.php');
			$this->session = new session();
		}
		$globalConfig = array();
		if(settingsData::exists($baseBaseUrl .'local/conf/globalConfig.json'))
		{
			$globalConfig = settingsData::read($baseBaseUrl .'local/conf/globalConfig.json', 'globalConfig');
			// Ok if it doesn't exist, user might have deleted to reset settings or something?
		}

		if (!file_exists($baseBaseUrl ."core/conf/globalConfig.php") || !is_readable($baseBaseUrl ."core/conf/globalConfig.php"))
		{
			echo json_encode(8);
			exit();
		}
		$defaultGlobalConfig = settingsData::defaults('globalConfig');
		$baseUrl = $baseBaseUrl."local/";
		$currentSelectedTheme = $this->session->returnCurrentSelectedTheme();
		$baseUrl .= $currentSelectedTheme."/";
		$config = settingsData::read($baseUrl.'conf/config.json', 'config');
		$defaultConfig = settingsData::defaults('config');
		$currentTheme = $this->loadSpecificVar($defaultConfig, $config, "currentTheme");
		if(is_dir($baseBaseUrl.'local/Themes/'.$currentTheme))
		{
			$themeDefaultSettings = settingsData::read($baseBaseUrl.'local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
		}
		else
		{
			$themeDefaultSettings = settingsData::read($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
		}
		include($baseBaseUrl.'core/php/loadVars.php');

		$fileName = $baseBaseUrl .'local/conf/globalConfig.json';

		$newInfoForConfig = [];
		foreach ($defaultGlobalConfig as $key => $value)
		{
			if(isset($newSaveStuff[$key]))
			{
				$newInfoForConfig[$key] = $newSaveStuff[$key];
			}
			else
			{
				$newInfoForConfig[$key] = $$key;
			}
		}

		if (!settingsData::write($fileName, $newInfoForConfig)) {
			throw new RuntimeException("Could not save upgraded settings");
		}

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