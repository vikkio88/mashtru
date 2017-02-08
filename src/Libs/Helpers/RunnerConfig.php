<?php


namespace Mashtru\Libs\Helpers;


class RunnerConfig
{
    private $namespaces;

    function __construct($namespaces = [])
    {
        $this->namespaces = $namespaces;
    }

    public function toArray()
    {
        return [
            'namespaces' => $this->namespaces
        ];
    }

}