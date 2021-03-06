<?php


use hispaSMS\DataConnectionProfileClient;
use hispaSMS\SmsClient;

require_once __DIR__ . '/../vendor/autoload.php';

$smsClient = new SmsClient(USERNAME, PASSWORD);
$smsClient->login();

echo 'smsClient validity is ', $smsClient->isValid() ? 'true' : 'false', "\n";

$dataConnectionProfileClient = new DataConnectionProfileClient(USERNAME, 'wrongpassword');
$dataConnectionProfileClient->login();

echo 'dataConnectionProfileClient validity is ', $dataConnectionProfileClient->isValid() ? 'true' : 'false', "\n";

assert(true === $smsClient->isValid());
assert(false === $dataConnectionProfileClient->isValid());
