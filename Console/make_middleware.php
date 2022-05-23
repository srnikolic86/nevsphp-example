<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

$middleware_name = $argv[1];
if (!str_ends_with($middleware_name, 'Middleware')) $middleware_name .= "Middleware";
$middleware_file = $middleware_name . '.php';
$middleware_path = '../App/Middleware/' . $middleware_file;
if (file_exists($middleware_path)) die ("\n\rthat middleware already exists\n\r\n\r");
$my_file = fopen($middleware_path, 'w') or die("\n\runable to open file " . $middleware_path . "\n\r\n\r");

$file_content = "<?php

namespace App\Middleware;

use Nevs\Middleware;
use Nevs\Request;
use Nevs\Response;

class ".$middleware_name." extends Middleware
{
    public function Before(Request &\$request): null|Response {
        return null;
    }

    public function After(Request &\$request, Response &\$response): void {
    }
}";


fwrite($my_file, $file_content);
fclose($my_file);
echo("\n\rmiddleware created\n\r\n\r");