<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

$controller_name = $argv[1];
if (!str_ends_with($controller_name, 'Controller')) $controller_name .= "Controller";
$controller_file = $controller_name . '.php';
$controller_path = '../App/Controllers/' . $controller_file;
if (file_exists($controller_path)) die ("\n\rthat controller already exists\n\r\n\r");
$my_file = fopen($controller_path, 'w') or die("\n\runable to open file " . $controller_path . "\n\r\n\r");

$file_content = "<?php

namespace App\Controllers;

use Nevs\Controller;
use Nevs\Response;

class " . $controller_name . " extends Controller
{
    public function ExampleMethod(): Response
    {
        return new Response('');
    }
}";


fwrite($my_file, $file_content);
fclose($my_file);
echo("\n\rcontroller created\n\r\n\r");