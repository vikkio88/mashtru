<?php


namespace Mashtru\Libs\Helpers;


class RunnerConfig
{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return [
            'name' => $this->name
        ];
    }

}