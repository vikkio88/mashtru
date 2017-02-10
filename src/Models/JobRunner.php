<?php


namespace Mashtru\Models;

use Exception;

class JobRunner
{
    protected $jobNamespaces = [];
    protected $log;

    function __construct($config = [])
    {
        $this->jobNamespaces = $config['namespaces'];
        $this->log = $config['log'];
    }

    public function run($job)
    {
        try {
            $jobCommand = $this->createJob($job->class_name, $job->args);
            return $jobCommand->fire();
        } catch (Exception $exception) {
            $this->reportError($job->class_name, $exception->getMessage());
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

    private function reportError($className, $errorMessage)
    {
        if (!$this->log) {
            return;
        }

        //Perform log
    }
}