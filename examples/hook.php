<?php
require '../vendor/autoload.php';

use Mashtru\JobManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Helpers\RunnerConfig;

$jobs = new JobManager(
    new DBConfig(
        'localhost',
        'mashtru',
        'root',
        'root'
    ),
    new RunnerConfig(
        [
            '\\',
            'App\Namespace\\'
        ]
    )
);


$jobs->fire();

