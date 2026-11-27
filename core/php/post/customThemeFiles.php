<?php
require_once __DIR__.'/../class/core.php';
require_once __DIR__.'/../class/session.php';

$session = new session();
if (!$session->startSession() || !$session->validate())
{
    echo json_encode(array('error' => 18));
    exit;
}

$path = $_POST['path'] ?? '';
$prefix = '../../local/Themes/';
if (!is_string($path) || !str_starts_with($path, $prefix))
{
    echo json_encode(false);
    exit;
}

$relativePath = substr($path, strlen($prefix));
if (!preg_match('~\A(?:Custom-Theme-[1-9][0-9]*(?:/(?:img(?:/Gear\.png)?|template|defaultSetting\.json))?)?\z~', $relativePath))
{
    echo json_encode(false);
    exit;
}

$path = __DIR__.'/../../../local/Themes';
foreach (explode('/', $relativePath) as $part)
{
    if ($part !== '')
    {
        $path .= '/'.$part;
    }
    if (is_link($path))
    {
        echo json_encode(false);
        exit;
    }
}

$result = match ($_POST['action'] ?? '') {
    'createFolder' => !str_ends_with($path, '.json') && !str_ends_with($path, '.png')
        && (is_dir($path) || mkdir($path)),
    'verifyDirIsThere' => is_dir($path),
    'verifyFileIsThere' => file_exists($path) === (($_POST['isThere'] ?? '') === 'true'),
    'deleteTheme' => preg_match('/\ACustom-Theme-[1-9][0-9]*\z/', $relativePath) && deleteCustomTheme($path),
    default => false,
};
echo json_encode($result);

function deleteCustomTheme($path)
{
    if (!is_dir($path))
    {
        return !file_exists($path);
    }
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file)
    {
        $removed = $file->isDir() && !$file->isLink() ? rmdir($file->getPathname()) : unlink($file->getPathname());
        if (!$removed)
        {
            return false;
        }
    }
    return rmdir($path);
}
