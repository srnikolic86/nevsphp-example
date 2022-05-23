<?php

use Nevs\Database;

class M_1652631566384_create_users_table
{
    function migrate(): void
    {
        $DB = new Database();
        $DB->CreateTable(['name' => 'users', 'fields' => [
            [
                'name' => 'id',
                'type' => 'int',
                'primary_key' => true,
                'auto_increment' => true
            ],
            [
                'name' => 'username',
                'type' => 'string'
            ],
            [
                'name' => 'password',
                'type' => 'string'
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime'
            ],
            [
                'name' => 'date_of_birth',
                'type' => 'date'
            ],
            [
                'name' => 'details',
                'type' => 'json'
            ],
            [
                'name' => 'active',
                'type' => 'bool'
            ]
        ]]);
    }
}
