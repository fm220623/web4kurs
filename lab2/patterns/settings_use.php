<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/singleton/Settings.php';

use Singleton\Settings;

$settings = Settings::get();

$settings->count = 25;
$settings->name = "soso sosok";
$settings->enabled = false;

echo "Count: " . $settings->count . "<br>";
echo "Name: " . $settings->name . "<br>";
echo "Enabled: " . ($settings->enabled ? 'true' : 'false') . "<br>";