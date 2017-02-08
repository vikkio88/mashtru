<?php


use Mashtru\Libs\Helpers\RunnerConfig;

class RunnerConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group RunnerConfig
     */
    public function itAcceptRightNumberOfParameters()
    {
        $runnerConfig = new RunnerConfig(
            [
                'App\Stuff'
            ]
        );
        $this->assertInstanceOf(RunnerConfig::class, $runnerConfig);
        $this->assertNotEmpty($runnerConfig);
    }

    /**
     * @test
     * @group RunnerConfig
     */
    public function itCastsToArray()
    {
        $expectedKeys = [
            'namespaces',
        ];

        $runnerConfig = new RunnerConfig(
            [
                'App\Banana'
            ]
        );

        $this->assertInstanceOf(RunnerConfig::class, $runnerConfig);
        $configArray = $runnerConfig->toArray();
        $this->assertNotEmpty($configArray);
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $configArray);
        }
    }

}
