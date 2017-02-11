<?php


namespace Mashtru;


use Mashtru\Libs\Factories\JobEntityFactory;
use Mashtru\Libs\Helpers\RunnerConfig;
use Mashtru\Libs\Interfaces\MashtruManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;
use Mashtru\Models\JobEntity;
use Mashtru\Models\JobRunner;

class JobManager implements MashtruManager, Job
{
    const TABLE_NAME = 'mashtru_jobs';
    /**
     * @var JobEntity
     */
    protected $jobDb;
    protected $jobRunner;

    public function __construct(DBConfig $dbConfig, RunnerConfig $runnerConfig)
    {
        $this->jobDb = JobEntityFactory::getInstance($dbConfig, self::TABLE_NAME);
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

    public function updateJob($name, $data = [])
    {
        return $this->jobDb->updateByName($name, $data);

    }

    public function toggleJob($name)
    {

    }

    public function removeJob($name)
    {
        $this->jobDb->deleteByName($name);
    }

    public function getName()
    {
        return self::class;
    }
}