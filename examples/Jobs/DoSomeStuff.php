<?php


namespace App\Scripts;


use Mashtru\Libs\Interfaces\Job;

class DoSomeStuff implements Job
{

    public function fire(array $parameters = [])
    {

        echo "I do some cron stuff!";
        //SOME STUFF


        //RETURN AN INT
        return 0;
    }

    public function getName()
    {
        return 'DoSomeStuff';
    }
}