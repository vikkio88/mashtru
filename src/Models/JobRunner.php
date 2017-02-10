<?php


namespace Mashtru\Models;

use Exception;

class JobRunner
{
    protected $jobNamespaces = [];

    function __construct($config = [])
    {
        $this->jobNamespaces = $config['namespaces'];
    }

    public function run($job)
    {
        try {
            $jobCommand = $this->createJob($job->class_name, $job->args);
            return $jobCommand->fire();
        } catch (Exception $exception) {
            $this->reportError($exception->getMessage());
        }
    }

    private function getJobClass($jobClassName)
    {
        foreach ($this->jobNamespaces as $jobNamespace) {
            $fullJobClassName = $jobNamespace . $jobClassName;
            if (class_exists($fullJobClassName)) {
                return $fullJobClassName;
            }
        }

        return false;
    }

    private function createJob($jobClassName, $args)
    {
        $jobClass = $this->getJobClass($jobClassName);
        if (empty($jobClass)) {
            throw new Exception(sprintf("Class %s not found", $jobClassName));
        }

        return new $jobClass($args);
    }

    private function reportError($errorMessage)
    {
        echo $errorMessage;
    }
}