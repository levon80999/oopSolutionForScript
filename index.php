<?php

declare(strict_types = 1);

use App\Application;

require_once 'vendor/autoload.php';

$application = Application::getInstance();

$application->run($argv[1]);