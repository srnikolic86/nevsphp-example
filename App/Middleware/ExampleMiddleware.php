<?php

namespace App\Middleware;

use Nevs\Middleware;
use Nevs\Request;
use Nevs\Response;

class ExampleMiddleware extends Middleware
{
    public function Before(Request &$request): null|Response {
        return null;
    }

    public function After(Request &$request, Response &$response): void {
    }
}