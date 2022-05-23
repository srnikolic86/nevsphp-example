<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

require_once('../vendor/autoload.php');
require_once('../Config/config.php');
require_once('../App/helpers.php');

use Nevs\Database;
use Nevs\Config;
use Nevs\Log;

date_default_timezone_set(Config::Get('timezone'));

$DB = new Database();

$command_name = $argv[1];

$data = [];
if (count($argv) >= 3) {
    $param_data = json_decode($argv[2], true);
    if ($param_data !== null) {
        $data = $param_data;
    }
}

Log::Write('Commands', 'running ' . $command_name . ' ' . json_encode($data));

$command = new $command_class();
$command->resolve($data);