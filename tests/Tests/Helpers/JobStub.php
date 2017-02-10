<?php

namespace Tests\Helpers;


class JobStub
{
    public $name;
    public $class_name;
    public $args;

    public function __construct($name, $className, $args = [])
    {
        $this->name = $name;
        $this->class_name = $className;
        $this->args = $args;
    }
}