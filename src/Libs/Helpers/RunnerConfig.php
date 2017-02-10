<?php


namespace Mashtru\Libs\Helpers;


class RunnerConfig
{
    private $namespaces;
    /**
     * @var bool
     */
    private $log;

    function __construct($namespaces = [], $log = false)
    {
        $this->namespaces = $namespaces;
        $this->log = $log;
    }

    public function toArray()
    {
        return [
            'namespaces' => $this->namespaces,
            'log' => $this->log
        ];
    }

}