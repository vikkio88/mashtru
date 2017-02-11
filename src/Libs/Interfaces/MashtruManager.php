<?php


namespace Mashtru\Libs\Interfaces;


use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Helpers\RunnerConfig;

interface MashtruManager
{
    public function __construct(DBConfig $dbConfig, RunnerConfig $runnerConfig);

    public function getAllJobs();

    public function getJob($name);

    public function getNextJobs();

    public function addJob($data = []);

    public function updateJob($name, $data = []);

    public function toggleJob($name);

    public function removeJob($name);

}