<?php


namespace Mashtru\Models;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class JobRunner
{
    protected $jobNamespaces = [];
    protected $enableLogs;
    protected $logger;

    function __construct($config = [])
    {
        $this->jobNamespaces = $config['namespaces'];
        $this->enableLogs = $config['enableLogs'];

        if ($this->enableLogs) {
            $this->logger = new Logger('JobRunner');
            $this->logger->pushHandler(
                new StreamHandler(
                    $config['logFile'],
                    Logger::INFO
                )
            );
        }
    }

    public function run($job)
    {
        $this->logInfo('running ' . $job->name);
        try {
            $jobCommand = $this->createJob($job->class_name, $job->args);
            return $jobCommand->fire();
        } catch (Exception $exception) {
            $this->reportError($job->class_name, $exception->getMessage());
        }
        $this->logInfo('finished ' . $job->name);
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
        if (!$this->enableLogs) {
            return;
        }

        $this->logger->error($className, [$errorMessage]);
    }

    private function logInfo($message)
    {
        if (!$this->enableLogs) {
            return;
        }

        $this->logger->info($message);
    }
}