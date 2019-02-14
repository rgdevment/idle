<?php

declare(strict_types=1);

namespace LinioPay\Idle\Queue\Service;

use LinioPay\Idle\Queue\Service;
use Zend\Stdlib\ArrayUtils;

abstract class DefaultService implements Service
{
    /** @var array */
    protected $config;

    public function getQueueConfig(string $queueIdentifier) : array
    {
        $this->validateQueue($queueIdentifier);

        $default = $this->config['queues']['default'] ?? [];

        $requested = $this->config['queues'][$queueIdentifier] ?? [];

        return ArrayUtils::merge($default, $requested);
    }

    public function getQueueWorkerConfig(string $queueIdentifier) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        return $queueConfig['worker'] ?? [];
    }

    protected function isQueueConfigured(string $queueIdentifier)
    {
        if (!isset($this->config['queues'][$queueIdentifier])) {
            return false;
        }

        return true;
    }

    protected function validateQueue(string $queueIdentifier)
    {
        if ($queueIdentifier === 'default' || !$this->isQueueConfigured($queueIdentifier)) {
            throw new \Exception('Invalid queue specified.');
        }
    }

    protected function getQueueQueueingErrorConfig(string $queueIdentifier) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        return $queueConfig['queue']['error'] ?? [];
    }

    protected function isQueueQueueingErrorSuppression(string $queueIdentifier) : bool
    {
        $errorConfig = $this->getQueueQueueingErrorConfig($queueIdentifier);

        return isset($errorConfig['suppression']) && $errorConfig['suppression'];
    }

    protected function getQueueQueueingParameters(string $queueIdentifier) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        return $queueConfig['queue']['parameters'] ?? [];
    }

    protected function getQueueDequeueingErrorConfig(string $queueIdentifier) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        return $queueConfig['dequeue']['error'] ?? [];
    }

    protected function isQueueDequeueingErrorSuppression(string $queueIdentifier) : bool
    {
        $errorConfig = $this->getQueueDequeueingErrorConfig($queueIdentifier);

        return isset($errorConfig['suppression']) && $errorConfig['suppression'];
    }

    protected function getQueueDequeueingParameters(string $queueIdentifier, array $parameters = []) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        $config = $queueConfig['dequeue']['parameters'] ?? [];

        return ArrayUtils::merge($config, $parameters);
    }

    protected function getQueueDeletingErrorConfig(string $queueIdentifier) : array
    {
        $queueConfig = $this->getQueueConfig($queueIdentifier);

        return $queueConfig['delete']['error'] ?? [];
    }

    protected function isQueueDeletingErrorSuppression(string $queueIdentifier) : bool
    {
        $errorConfig = $this->getQueueDeletingErrorConfig($queueIdentifier);

        return isset($errorConfig['suppression']) && $errorConfig['suppression'];
    }

    protected function throwableToArray(\Throwable $throwable)
    {
        return [
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ];
    }
}
