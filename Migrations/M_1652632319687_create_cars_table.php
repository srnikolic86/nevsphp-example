<?php

use Nevs\Database;

class M_1652632319687_create_cars_table 
{
    function migrate() : void
    {
        $DB = new Database();
        $DB->CreateTable(['name'=>'cars', 'fields'=>[
            [
                'name' => 'id',
                'type' => 'int',
                'primary_key' => true,
                'auto_increment' => true
            ],
            [
                'name' => 'name',
                'type' => 'string'
            ],
            [
                'name' => 'user_id',
                'type' => 'int',
                'foreign_key' => 'users'
            ]
        ]]);
    }
}
