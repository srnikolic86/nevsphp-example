<?php

namespace App\Models;

use Nevs\Model;

class Car extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'cars';
    }
}