<?php


use Carbon\Carbon;
use Mashtru\JobManager;
use Mashtru\Libs\Factories\JobEntityFactory;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Models\JobEntity;

class JobEntityTest extends PHPUnit_Framework_TestCase
{

    const TIME_FORMAT = 'Y-m-d H:i:s';
    /**
     * @var JobEntity
     */
    private $jobEntity;

    public function setUp()
    {
        $this->jobEntity = JobEntityFactory::getInstance(
            new DBConfig(
                'localhost',
                'mashtru',
                'root',
                'root'
            ),
            JobManager::TABLE_NAME
        );
        $this->jobEntity->uninstall();
        $this->jobEntity->install();
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itCreatesANewJobAndAppliesFireTime()
    {
        $testName = 'testJob';
        $data = $this->getDummyData($testName);
        $diff = $data['delta_minutes'] = 5;
        $now = Carbon::now();
        $this->jobEntity->create(
            $data
        );
        $savedJob = $this->jobEntity->getByName($testName);
        $this->assertNotEmpty($savedJob);
        $this->assertEquals($now->addMinutes($diff)->format(self::TIME_FORMAT), $savedJob->fire_time);

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

    /**
     * @test
     * @group JobEntity
     * @group cose
     */
    public function itGetsJobsReadyToFireAndWithRightPriority()
    {
        $testNext = 'testNext';
        $elements = 5;
        foreach (range(0, $elements) as $i) {
            $data = $this->getDummyData($testNext . $i);
            $data['priority'] = $i;
            $data['fire_time'] = Carbon::now()->addMinutes(-2)->format(JobEntity::TIME_FORMAT);
            $this->jobEntity->create(
                $data
            );
        }
        $result = $this->jobEntity->getNext();
        $this->assertNotEmpty($result);
        $this->assertCount($elements + 1, $result);
        $previousPriority = $elements;
        foreach ($result as $job) {
            $this->assertLessThanOrEqual($previousPriority, $job->priority);
            $previousPriority = $job->priority;
        }
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itReturnsFileIfTryToInsertDuplicateJobName()
    {
        $testDuplicate = 'testDuplicate';
        $data = $this->getDummyData($testDuplicate);
        $result = $this->jobEntity->create(
            $data
        );
        $this->assertNotFalse($result);
        $result = $this->jobEntity->create(
            $data
        );
        $this->assertFalse($result);
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itUpdatesByName()
    {
        $testUpdate = 'testUpdate';
        $data = $this->getDummyData($testUpdate);
        $this->jobEntity->create(
            $data
        );
        $updatedName = $testUpdate . '1';
        $updatedClassName = 'NewClass';
        $this->jobEntity->updateByName(
            $testUpdate,
            [
                'name' => $updatedName,
                'class_name' => $updatedClassName
            ]
        );
        $this->assertEquals($updatedName, $this->jobEntity->getByName($updatedName)->name);
        $this->assertEquals($updatedClassName, $this->jobEntity->getByName($updatedName)->class_name);
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itTogglesJob()
    {
        $testToggle = 'testToggle';
        $data = $this->getDummyData($testToggle);
        $this->jobEntity->create(
            $data
        );
        $starting = $this->jobEntity->getByName($testToggle)->active;
        $this->jobEntity->toggle($testToggle);
        $new = $this->jobEntity->getByName($testToggle)->active;
        $this->assertNotEquals($starting, $new);
        $this->jobEntity->toggle($testToggle);
        $new = $this->jobEntity->getByName($testToggle)->active;
        $this->assertEquals($starting, $new);
    }

    /**
     * @test
     * @group JobEntity
     */
    public function itUpdatesTheFireTime()
    {
        $testFire = 'testFire';
        $now = Carbon::now();
        $data = $this->getDummyData($testFire, $now);
        $diff = $data['delta_minutes'] + 5;
        $this->jobEntity->create(
            $data
        );
        $insertedJob = $this->jobEntity->getByName($testFire);
        $firstFireTime = $insertedJob->fire_time;
        $insertedJob->delta_minutes = $diff;
        $this->jobEntity->updateFireTime($insertedJob);
        $updatedJob = $this->jobEntity->getByName($testFire);
        $secondFireTime = $updatedJob->fire_time;
        $this->assertNotEquals($firstFireTime, $secondFireTime);
        $this->assertEquals($now->addMinutes($diff)->format(self::TIME_FORMAT), $secondFireTime);

    }

    private function getDummyData($testName, $fireTime = null)
    {
        return [
            'name' => $testName,
            'class_name' => 'TestJob',
            'args' => null,
            'delta_minutes' => 10,
            'active' => true,
            'fire_time' => $fireTime,
        ];
    }

}
