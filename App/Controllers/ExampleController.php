<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Car;
use Nevs\Queue;
use Nevs\Controller;
use Nevs\Response;

class ExampleController extends Controller
{
    public function ExampleGet(): Response
    {
        $user = User::Create([
            'username' => 'user1',
            'password' => 'password1',
            'created_at' => new \DateTime(),
            'date_of_birth' => new \DateTime(),
            'details' => ['test' => true],
            'active' => true
        ]);

        $user->Update(['username' => 'user2', 'active' => false]);

        $car = Car::Create([
            'name' => 'ferari',
            'user_id' => $user->id
        ]);

        Queue::Add('queue1', 'Test', []);

        return new Response(json_encode([]));
    }

    public function ExampleGetParameter(): Response
    {
        return new Response(json_encode($this->request->parameters));
    }
}