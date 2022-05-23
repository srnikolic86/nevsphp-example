<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

$migration_name = "M_" . floor(microtime(true) * 1000) . '_' . $argv[1];
$migration_file = $migration_name . '.php';
$my_file = fopen('../Migrations/' . $migration_file, 'w') or die("\n\runable to open file ../Migrations/" . $migration_file . "\n\r\n\r");

$migration_content = "<?php
use Nevs\Database;
class " . $migration_name . " 
{
    function migrate() : void
    {
        \$DB = new Database();
    }
}";

if (str_contains($migration_name, 'create')) {
    $migration_content = "<?php
use Nevs\Database;
class " . $migration_name . " 
{
    function migrate() : void
    {
        \$DB = new Database();
        \$DB->CreateTable(['name'=>'name', 'fields'=>[]]);
    }
}";
}

if (str_contains($migration_name, 'modify') || str_contains($migration_name, 'add') || str_contains($migration_name, 'remove')) {
    $migration_content = "<?php
use Nevs\Database;
class " . $migration_name . " 
{
    function migrate() : void
    {
        \$DB = new Database();
        \$DB->ModifyTable(['name'=>'name', 'fields'=>[
            \"add\" => [],
            \"modify\" => [],
            \"remove\" => []
        ]]);
    }
}";
}

if (str_contains($migration_name, 'delete')) {
    $migration_content = "<?php
use Nevs\Database;
class " . $migration_name . " 
{
    function migrate() : void
    {
        \$DB = new Database();
        \$DB->DeleteTable('name');
    }
}";
}

fwrite($my_file, $migration_content);
fclose($my_file);
echo("\n\rmigration created\n\r\n\r");