<?php


use Mashtru\JobManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Models\JobEntity;

class JobEntityTest extends PHPUnit_Framework_TestCase
{
    private $jobEntity;

    public function setUp()
    {
        $this->jobEntity = new JobEntity(
            (new DBConfig(
                'localhost',
                'mashtru',
                'root',
                'root'
            ))->toArray(),
            JobManager::TABLE_NAME
        );

        $this->jobEntity->uninstall();
        $this->jobEntity->install();
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itCreatesANewJob()
    {
        $this->jobEntity->create(
            [
                'name' => 'testJob',
                'class_name' => 'TestJob',
                'args' => null,
                'delta_minutes' => 10,
                'active' => true,
                'fire_time' => null,
            ]
        );
    }


    /**
     * @test
     * @group JobEntity
     */
    public function itCreatesAndRemoveANewJob()
    {

    }

    /**
     * @test
     * @group JobEntity
     */
    public function itGetsOneJobByName()
    {

    }

    /**
     * @test
     * @group JobEntity
     */
    public function itGetsMultipleJobs()
    {

    }

}
