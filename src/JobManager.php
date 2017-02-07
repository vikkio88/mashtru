<?php


namespace Mashtru;


use DateTime;
use Libs\Interfaces\MashtruManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;
use Mashtru\Libs\Models\JobEntity;

class JobManager implements MashtruManager
{
    const TABLE_NAME = 'mashtru_jobs';
    protected $jobDb;

    public function __construct(DBConfig $config)
    {
        $this->jobDb = new JobEntity($config->toArray(), self::TABLE_NAME);
    }

    public function getAllJobs()
    {
        return $this->jobDb->getAll();
    }

    public function getJob($name)
    {
        return $this->jobDb->getByName($name);
    }

    public function getNextJobs()
    {
        return $this->jobDb->getNext();

    }

    public function addJob(Job $job)
    {
        $this->jobDb->create(
            $job->toArray()
        );
    }

    public function updateJob(Job $job)
    {
        // TODO: Implement updateJob() method.
    }

    public function toggleJob($name)
    {
        // TODO: Implement toggleJob() method.
    }

    public function removeJob($name)
    {
        $this->jobDb->deleteByName($name);
    }

    public function updateFireTime(DateTime $newFireTime)
    {
        // TODO: Implement updateFireTime() method.
    }
}