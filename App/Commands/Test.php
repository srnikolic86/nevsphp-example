<?php

namespace App\Commands;

use Nevs\Command;

class Test extends Command
{
    public function resolve(array $data = []): void
    {
        error_log('Test command executed...');
    }
}