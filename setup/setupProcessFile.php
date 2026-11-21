<?php
$setupProcess = 'preStart';
$setupStatusFile = __DIR__.'/../local/.setup-status';
if (is_file($setupStatusFile))
{
    $setupProcess = file_get_contents($setupStatusFile) ?: $setupProcess;
}
