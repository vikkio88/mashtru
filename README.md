# mashtru
[![Build Status](https://travis-ci.org/vikkio88/mashtru.svg?branch=master)](https://travis-ci.org/vikkio88/mashtru)

**mashtru** will manage scheduled task on shared hosting (and everywhere else really)

## Problem
Shared php web hosting, usually give you a limited number of scheduled task script (from 1 to 5), and if you need you app to perform some async cron jobs, and you dont want to forget about [single responsibility principle](https://en.wikipedia.org/wiki/Single_responsibility_principle), you will just need to **mashtru**.
 
## Hook script
Set the only scheduled task to be the ```hook.php``` script, which will be something like this
```php
<?php
require '../vendor/autoload.php';

use Mashtru\JobManager;
use Mashtru\Libs\Helpers\DBConfig;
use Mashtru\Libs\Helpers\RunnerConfig;

$jobs = new JobManager(
    new DBConfig(
        'localhost',
        'mashtru',
        'root',
        'root'
    ),
    new RunnerConfig(
        [
            'App\Scripts\\'
        ]
    )
);

$jobs->fire();
```

and imagine to have a job si defined in the file ```DosomeStuff.php```

```php
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
```

The fire method of this class will be called how many times you defined it in the Job configuration.


## Configure Jobs
**mashtru** uses a single table called ```mashtru_jobs```, there the structure is as follows
```sql
CREATE TABLE mashtru_jobs(
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    class_name VARCHAR(255) DEFAULT NULL,
    args TEXT DEFAULT NULL,
    delta_minutes INT DEFAULT NULL,
    active BOOL DEFAULT 1,
    fire_time TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    created_at TIMESTAMP NOT NULL,
    PRIMARY KEY(id),
    INDEX `name` (`name`)
);
```
 column | description 
--- | --- 
**id** | the incremental id for the job
**name** | the job name (used to identify a job)
**args** | a text field that will be passed into the fire function (I would cast it with ```json_decode``` as config param)
**class_name** | the name of the class which ```fire()``` method will be called
**delta_minutes** | the difference on minutes of the iteration for this job (it will be executed every *delta_minutes* minutes)
**active** | whether or not the job is active
**fire_time** | calculated column that will tell mashtru whether the job is ready to be fired or not


The class ```JobManager``` offers utility to install/uninstall/add/delete/update/get jobs from this table. The implementeation of those action is delegated to the library user.
I will use it within a protected rest-api i.e. so I would be able to set manage the jobs using a rest-api.

## Collabs
This is a silly lib that I wrote for me, every help of feedback is well appreciated.

# ToDos

 - Make table_name configurable
 - Replace ```delta_minutes``` with cronjob-like configuration


