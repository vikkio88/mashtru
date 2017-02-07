<?php


namespace Libs\Interfaces;


use DateTime;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;

interface MashtruManager
{
    public function __construct(DBConfig $config);

    public function getAllJobs();

    public function getJob($name);

    public function getNextJobs();

    public function addJob(Job $job);

    public function updateJob(Job $job);

    public function toggleJob($name);

    public function removeJob($name);

    public function updateFireTime(DateTime $newFireTime);
}