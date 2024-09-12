<?php

use Core\Kernel;

const project_root = __DIR__;
require project_root . '/vendor/autoload.php';

$app = new Kernel();
$app->addRoutes()->addNotFound()->run();