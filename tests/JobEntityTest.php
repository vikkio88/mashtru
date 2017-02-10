<?php


use Mashtru\JobManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Models\JobEntity;

class JobEntityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JobEntity
     */
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
        $testName = 'testJob';
        $this->jobEntity->create(
            $this->getDummyData($testName)
        );

        $this->assertNotEmpty($this->jobEntity->getByName($testName));
    }


    /**
     * @test
     * @group JobEntity
     */
    public function itCreatesAndRemoveANewJob()
    {
        $testRemove = 'toRemove';
        $this->jobEntity->create(
            $this->getDummyData($testRemove)
        );

        $this->jobEntity->deleteByName($testRemove);
        $this->assertEmpty($this->jobEntity->getByName($testRemove));
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itGetsOneJobByName()
    {
        $testGet = 'toGet';
        $this->jobEntity->create(
            $this->getDummyData($testGet)
        );
        $this->assertNotEmpty($this->jobEntity->getByName($testGet));
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itGetsMultipleJobs()
    {
        $testAll = 'testAll';
        $elements = 5;
        foreach (range(0, $elements) as $i) {
            $this->jobEntity->create(
                $this->getDummyData($testAll . $i)
            );
        }

        $result = $this->jobEntity->getAll();
        $this->assertNotEmpty($result);
        $this->assertCount($elements + 1, $result);

    }

    private function getDummyData($testName)
    {
        return [
            'name' => $testName,
            'class_name' => 'TestJob',
            'args' => null,
            'delta_minutes' => 10,
            'active' => true,
            'fire_time' => null,
        ];
    }

}
