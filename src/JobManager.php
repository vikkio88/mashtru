<?php


namespace Mashtru;


use Mashtru\Libs\Helpers\RunnerConfig;
use Mashtru\Libs\Interfaces\MashtruManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;
use Mashtru\Models\JobEntity;
use Mashtru\Models\JobRunner;

class JobManager implements MashtruManager, Job
{
    const TABLE_NAME = 'mashtru_jobs';
    protected $jobDb;
    protected $jobRunner;

    public function __construct(DBConfig $dbConfig, RunnerConfig $runnerConfig)
    {
        $this->jobDb = new JobEntity($dbConfig->toArray(), self::TABLE_NAME);
        $this->jobRunner = new JobRunner($runnerConfig->toArray());
    }

    public function fire(array $parameters = [])
    {
        $jobs = $this->getNextJobs();
        foreach ($jobs as $job) {
            if ($this->jobRunner->run($job)
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