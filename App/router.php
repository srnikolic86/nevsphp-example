<?php

use Nevs\Router;
use Nevs\RouteGroup;
use Nevs\Route;

const NEVS_ROUTER = new Router([
    new RouteGroup("/", [
        new Route("GET", "example", 'ExampleController', "ExampleGet"),
        new Route("GET", "example", 'ExampleController', "ExampleGetParameter", ['parameter1', 'parameter2'])
    ], ['ExampleMiddleware'])
]);