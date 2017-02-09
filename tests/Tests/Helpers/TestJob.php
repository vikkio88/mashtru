<?php


namespace Tests\Helpers;


use Mashtru\Libs\Interfaces\Job;

class TestJob implements Job
{

    public function fire(array $parameters = [])
    {
        //Doing some stuff
        return 0;
    }

    public function getName()
    {
        return "test_stub";
    }
}