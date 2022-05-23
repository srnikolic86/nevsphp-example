<?php

if (count($argv) < 2) {
    die("\n\rneed more parameters\n\r\n\r");
}

$model_name = $argv[1];
$model_file = $model_name . '.php';
$model_path = '../App/Models/' . $model_file;
if (file_exists($model_path)) die ("\n\rthat model already exists\n\r\n\r");
$my_file = fopen($model_path, 'w') or die("\n\runable to open file " . $model_path . "\n\r\n\r");

$file_content = "<?php

namespace App\Models;

use Nevs\Model;

class " . $model_name . " extends Model
{
    public function __construct()
    {
        parent::__construct();

        \$this->table = 'table_name';
    }
}";


fwrite($my_file, $file_content);
fclose($my_file);
echo("\n\rmodel created\n\r\n\r");