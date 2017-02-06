<?php


use Mashtru\Libs\Helpers\DBConfig;

class DBConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group DBConfig
     */
    public function itAcceptRightNumberOfParameters()
    {
        $dbConfig = new DBConfig(
            'a',
            'a',
            'a',
            'a'
        );
        $this->assertInstanceOf(DBConfig::class, $dbConfig);
        $this->assertNotEmpty($dbConfig);
    }

    /**
     * @test
     * @group DBConfig
     */
    public function itCastsToArray()
    {
        $host = 'random.host';
        $db = 'a_db_name';
        $user = 'mario.rossi';
        $password = 'qwerty';
        $expectedKeys = [
            'host',
            'db',
            'user',
            'password'
        ];

        $dbConfig = new DBConfig(
            $host,
            $db,
            $user,
            $password
        );

        $this->assertInstanceOf(DBConfig::class, $dbConfig);
        $configArray = $dbConfig->toArray();
        $this->assertNotEmpty($configArray);
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $configArray);
        }
    }

}
