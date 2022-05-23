<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

$command_name = $argv[1];
$command_file = $command_name . '.php';
$command_path = '../App/Commands/' . $command_file;
if (file_exists($command_path)) die ("\n\rthat command already exists\n\r\n\r");
$my_file = fopen($command_path, 'w') or die("\n\runable to open file " . $command_path . "\n\r\n\r");

$file_content = "<?php

namespace App\Commands;

use Nevs\Command;

class " . $command_name . " extends Command
{
    public function resolve(array \$data = []): void
    {
    }
}";


fwrite($my_file, $file_content);
fclose($my_file);
echo("\n\rcommand created\n\r\n\r");