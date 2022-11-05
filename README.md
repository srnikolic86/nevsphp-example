# Table of Contents
 - [Intro](#intro)
 - [Router](#router)
 - [Middleware](#middleware)
 - [Controllers](#controllers)
   - [Validation](#validation)
 - [Database](#database)
   - [Create a table](#create-a-table)
   - [Modify a table](#modify-a-table)
   - [Delete a table](#delete-a-table)
   - [Execute statements](#execute-statements)
     - [Any statement](#any-statement)
     - [SELECT statement](#select-statement)
     - [INSERT statement](#insert-statement)
   - [Migrations](#migrations)
 - [Models](#models)
   - [Create objects](#create-objects)
   - [Find object by private key](#find-object-by-private-key)
   - [Select objects using a SELECT statement](#select-objects-using-a-select-statement)
   - [Update objects](#update-objects)
   - [Delete objects](#delete-objects)
   - [Get related objects](#get-related-objects)
 - [Commands](#commands)
 - [Queues](#queues)
 - [Log](#log)


# Intro

To use NevsPHP you need to have these two global constants defined:
 - _NEVS_CONFIG_ ([app config](#config))
 - _NEVS_ROUTER_ ([_Router_ object](#router))

This example is using _App/config.php_ and _App/router.php_ to create those constants. Make sure that you convert _config.php.example_ to _config.php_ and adjust the settings according to your setup.

PHP console commands executed in the _Commands_ folder are specific to this example and are not a part of the NevsPHP framework.

# Config
This is minimal app config:
```php
const NEVS_CONFIG = [
    'app_root' => '/var/www/html/',
    'router_base' => '',
    'db' => [
        'host' => 'db',
        'username' => 'root',
        'password' => 'root',
        'database' => 'nevs',
        'charset' => 'utf8',
        'migrations_table' => 'nevs_migrations',
        'model_table' => 'nevs_model',
        'queue_table' => 'nevs_queue',
        'migrations_folder' => 'Migrations/'
    ],
    'timezone' => 'Europe/Berlin',
    'enabled_logs' => []
];
```

# Router

This is an example of a router:

```php
const NEVS_ROUTER = new Router([
    new RouteGroup("/", [
        new Route("GET", "example", 'ExampleController', "ExampleGet"),
        new Route("POST", "example", 'ExampleController', "ExampleGet"),
        new Route("GET", "example", 'ExampleController', "ExampleGetParameter", ['parameter1', 'parameter2'])
    ], ['ExampleMiddleware'])
]);
```
Root element needs to be a group.\
Each group can hold other groups or routes.

# Middleware

To create a middleware run this command in _Console_ folder:
```
php make_middleware.php middleware_name
```

Middlewares are resolved like this:
1. _Before()_ methods of all middlewares in the order in which middlewares were added
2. Controller method (as per route)
3. _After()_ methods of all middlewares in the opposite order than the one in which middlewares were added

_Before_ method can return either _null_ or _Response_ object. If it returns _Response_ it will stop any further middleware and controller execution and process that _Response_.


# Controllers

To create a controller run this command in _Console_ folder:
```
php make_controller.php controller_name
```
Controller has a _protected Request $request_ which can be used to access the request data and parameters.

## Validation

To validate a request put something like this into your controller:
```php
$validation = $this->request->Validate([
    'a' => 'int',
    'b' => 'string',
    'c' => 'email',
    'd' => 'float',
    'e' => 'bool',
    'f' => 'array'
]);
if ($validation !== true) {
    return new Response(json_encode($validation), ['HTTP/1.1 400 Bad Request']);
}
```

These are available rules:
- int
- float
- bool
- string
- array
- email

# Database

Use _global $DB_ object to access the database.

## Create a table
Use _$DB->CreateTable($data)_ to create a table.\
Here is an example:
```php
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
    ]
]]);

$DB->CreateTable(['name'=>'cars', 'fields'=>[
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
        'name' => 'owner',
        'type' => 'int',
        'foreign_key' => 'users'
    ]
]]);
```
These are available field types:
- _int_
- _bigint_
- _float_
- _double_
- _string_
- _bool_
- _tinytext_
- _text_
- _mediumtext_
- _longtext_
- _date_
- _datetime_
- _json_

These are available field properties:
 - _name_ - string
 - _type_ - string
 - _primary_key_ - boolean
 - _foreign_key_ - name of the related table as string
 - _auto_increment_ - boolean
 - _nullable_ - boolean
 - _default_value_ - this is LITERALLY copied into the SQL query after the DEFAULT keyword

## Modify a table
Use _$DB->ModifyTable($data)_ to modify a table.\
Here is an example:
```php
 $DB->ModifyTable([
    'name' => 'users',
    'modify' => [
        [
            'old_name' => 'password',
            'new_name' => 'password',
            'type' => 'text'
        ],
    ],
    'add' => [
        [
            'name' => 'email',
            'type' => 'string'
        ]
    ],
    'remove' => [
        'username'
    ]
]);
```
_Name_ is required, _modify_, _add_ and _remove_ are not.

## Delete a table
Use _$DB->DeleteTable($table_name)_ to delete a table.\
Here is an example:
```php
 $DB->DeleteTable('cars');
```
## Execute statements

### Any statement
Use _$DB->Execute($statement, $params)_.\
This returns _mysqli_stmt_ or _false_.
Here is an example:
```php
 $DB->Execute('DELETE FROM `cars` WHERE `age`<?', [$minimum_age]);
```

### SELECT statement
Use _$DB->ExecuteSelect($statement, $params)_.\
This returns associative array of results or _false_;
Here is an example:
```php
 $DB->Execute('SELECT * FROM `cars` WHERE `age`>?', [$minimum_age]);
```

### INSERT statement
Use _$DB->ExecuteInsert($statement, $params)_.\
This returns inserted id or _false_;
Here is an example:
```php
 $DB->Execute('INSERT INTO `cars` (`name`, `age`) VALUES (?, ?)', [$name, $age]);
```

## Migrations

To create a migration run this command in _Console_ folder:
```
php make_migration.php migration_name
```
Migrations should use the _$DB_ object to modify the database.\
If migration's name contains 'create' it will crate a template to insert a table.\
If migration's name contains 'modify', 'add' or 'remove' it will crate a template to modify a table.\
If migration's name contains 'delete' it will crate a template to delete a table.

To run migrations run this command in _Console_ folder (it will run _Migrations::Migrate(false)_):
```
php migrate.php
```

To empty the database and run migrations run this command in _Console_ folder  (it will run _Migrations::Migrate(true)_):
```
php migrate.php fresh
```

# Models
To create a model run this command in _Console_ folder:
```
php make_model.php model_name
```
In the constructor you should assign values to some these private members:
 - _$table_ - _'table_name'_ by default
 - _$id_field_ - _'id'_ by default
 - _$hidden_ - empty array by default (used to hide some fields like password fields)

## Create objects
Use _Model::Create($data)_.
Here is an example:
```php
$car = Car::Create([
    'name' => 'bumblebee',
    'age' => 42 
]);
```

## Find object by private key
Use _Model::Find($key)_.
Here is an example:
```php
$car = Car::Find(1);
```

## Select objects using a SELECT statement
Use _Model::Select($where, $params)_.
Here is an example:
```php
$expired_cars = Car::Select('age>?', [$maximum_age]);
```

## Update objects
Use _$object->Update($data)_.
Here is an example:
```php
$car->Update([
    'name' => 'bumblebee',
    'age' => 42
]);
```

## Delete objects
Use _$object->Delete()_.
Here is an example:
```php
$car->Delete();
```

## Get related objects
Use _$object->GetRelated($table)_.
Here is an example:
```php
$car->GetRelated('users');
```
This returns an associative array of all records from the _$table_ related to the object.

# Commands

To create a command run this in _Console_ folder:
```
php make_command.php command_name
```
To execute a command run this in _Console_ folder:
```
php run_command.php command_name
```
_Command::Resolve()_ method is called when the command is executed.

# Queues
To put a command into a queue for later execution use _Queue::Add(string $queue, string $command, array $data = [])_;
Here is an example:
```php
Queue::Add('TestQueue', 'TestCommand', ['param1'=>1, 'param2'=>'abc'])
```
To process a queue use _Queue::Process(string $queue_name)_.


# Log

Use _Log::Write($category, $message)_ method to log events and _config.php_ to list all enabled categories.\
These are available categories:
- Database
- Routing
- Request

Everything is outputted into PHP error log.