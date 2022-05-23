<?php
require_once('../vendor/autoload.php');
require_once('../App/config.php');
require_once('../App/router.php');

\Nevs\Migrations::Migrate(((count($argv) > 1) && ($argv[1] == 'fresh')));