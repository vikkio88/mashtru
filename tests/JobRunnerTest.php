<?php


namespace Tests;


use Mashtru\Libs\Helpers\RunnerConfig;
use Mashtru\Models\JobRunner;
use Tests\Helpers\JobStub;

class JobRunnerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group JobRunner
     */
    public function itRunsAJobAutoLoaded()
    {
        $jobRunner = new JobRunner(
            (new RunnerConfig(['Tests\Helpers\\']))->toArray()
        );

        $jobStub = new JobStub(
            'test',
            'TestJob'
        );

        $this->assertEquals(0, $jobRunner->run($jobStub));
    }

}
