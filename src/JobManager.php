<?php


namespace Mashtru;


use DateTime;
use Libs\Helpers\DbHelper;
use Libs\Interfaces\MashtruManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Interfaces\Job;

class JobManager implements MashtruManager
{
    const TABLE_NAME = 'mashtru_jobs';
    const TIME_FORMAT = 'Y-m-d H:i:s';
    protected $db;

    public function __construct(DBConfig $config)
    {
        $this->db = new DbHelper($config->toArray());
    }

    private function table()
    {
        return $this->db->table(self::TABLE_NAME);
    }

    public function getAllJobs()
    {
        return $this->table()->fetchAll();
    }

    public function getJob($name)
    {
        return $this->table()
            ->where('name', $name)
            ->fetch();
    }

    public function getNextJobsToFire()
    {
        $now = new DateTime();
        return $this->table()
            ->where('fire_time <=', $now->format(self::TIME_FORMAT))
            ->where('active', true)
            ->fetchAll();
    }

    public function addJob(Job $job)
    {
        $this->db->insert(
            self::TABLE_NAME, $job->toArray()
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
        // TODO: Implement removeJob() method.
    }

    public function updateFireTime(DateTime $newFireTime)
    {
        // TODO: Implement updateFireTime() method.
    }
}