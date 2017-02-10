<?php


namespace Mashtru\Libs\Helpers;


class RunnerConfig
{
    private $namespaces;
    protected $enableLog;
    protected $logFile;

    function __construct($namespaces = [], $enableLog = false, $logFile = 'mashtru.log')
    {
        $this->namespaces = $namespaces;
        $this->enableLog = $enableLog;
        $this->logFile = $logFile;
    }

    public function toArray()
    {
        return [
            'namespaces' => $this->namespaces,
            'enableLog' => $this->enableLog,
            'logFile' => $this->logFile
        ];
    }

}