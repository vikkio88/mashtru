<?php


namespace Mashtru\Libs\Factories;


use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Models\JobEntity;

class JobEntityFactory
{
    public static function getInstance(DBConfig $config, $table)
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new JobEntity(
                $config->toArray(),
                $table
            );
        }
        return $inst;
    }
}