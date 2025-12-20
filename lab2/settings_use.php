<?php

require_once 'patterns/singleton/Settings.php';
use Singleton\Settings;

$settings = Settings::get();

$settings->count = 25;
$settings->name = "soso sosok";
$settings->enabled = false;

echo "Count: " . $settings->count . "<br>";
echo "Name: " . $settings->name . "<br>";
echo "Enabled: " . ($settings->enabled ? 'true' : 'false') . "<br>";
