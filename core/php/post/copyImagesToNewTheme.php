<?php
require_once("../../../core/php/class/core.php");
$core = new core();
require_once("../../../core/php/class/session.php");
$session = new session();
if (!$session->startSession() || !$session->validate())
{
	echo json_encode(array('error' => 18));
	exit();
}
$themeNumber = settingsData::input($_POST['themeNumber'] ?? null, 0);
if ($themeNumber < 1)
{
	echo json_encode(false);
	exit();
}
$destination = '../../../local/Themes/Custom-Theme-'.$themeNumber.'/';
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = '../../../core/Themes/'.$currentTheme.'/';
if(is_dir('../../../local/Themes/'.$currentTheme))
{
	$directory = '../../../local/Themes/'.$currentTheme.'/';
}
foreach (['template', 'img'] as $folder)
{
	foreach (new FilesystemIterator($directory.$folder) as $asset)
	{
		if ($asset->isFile() && !$asset->isLink()
			&& in_array(strtolower($asset->getExtension()), ['css', 'map', 'gif', 'png', 'jpeg', 'jpg', 'svg', 'webp'], true)
			&& !copy($asset->getPathname(), $destination.$folder.'/'.$asset->getFilename()))
		{
			echo json_encode(false);
			exit();
		}
	}
}
echo json_encode(true);
exit();
