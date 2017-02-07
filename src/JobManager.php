<?php


namespace Mashtru;


use DateTime;
use Libs\Interfaces\MashtruManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;
use Mashtru\Libs\Models\JobEntity;

class JobManager implements MashtruManager, Job
{
    const TABLE_NAME = 'mashtru_jobs';
    protected $jobDb;

    public function __construct(DBConfig $config)
    {
        $this->jobDb = new JobEntity($config->toArray(), self::TABLE_NAME);
    }

    public function fire()
    {
        $jobs = $this->getNextJobs();
        foreach ($jobs as $job) {
            if ($this->jobRunner->fire($job)
            ) {
                $this->jobDb->updateFireTime($job);
            }
        }
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

    public function addJob($data = [])
    {
        $this->jobDb->create(
            $data
        );
    }

    public function updateJob($data = [])
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

    public function getName()
    {
        return [
            'name' => self::class
        ];
    }
}