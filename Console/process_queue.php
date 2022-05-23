<?php

require_once('../vendor/autoload.php');
require_once('../App/config.php');
require_once('../App/router.php');

\Nevs\Queue::Process('queue1');