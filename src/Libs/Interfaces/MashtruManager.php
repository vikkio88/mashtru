<?php


namespace Libs\Interfaces;


use Mashtru\Libs\Helpers\DBConfig;

interface MashtruManager
{
    public function __construct(DBConfig $config);

    public function getAllJobs();

    public function getJob($name);

    public function getNextJobs();

    public function addJob($data = []);

    public function updateJob($data = []);

    public function toggleJob($name);

    public function removeJob($name);

}