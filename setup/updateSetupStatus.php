<?php
require_once __DIR__.'/../core/php/class/core.php';
require_once __DIR__.'/../core/php/class/session.php';

$session = new session();
if (!$session->startSession() || !$session->validate())
{
    echo json_encode(array('error' => 18));
    exit;
}

$status = $_POST['status'] ?? null;
if (!in_array($status, array('step1', 'step2', 'step3', 'step4', 'step5', 'finished'), true))
{
    http_response_code(400);
    exit;
}

if (file_put_contents(__DIR__.'/../local/.setup-status', $status, LOCK_EX) === false)
{
    http_response_code(500);
    exit;
}

echo json_encode($status);
