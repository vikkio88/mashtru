<?php

namespace Tests\Helpers;


class JobStub
{
    public $name;
    public $className;
    public $args;

    public function __construct($name, $className, $args = [])
    {
        $this->name = $name;
        $this->className = $className;
        $this->args = $args;
    }
}