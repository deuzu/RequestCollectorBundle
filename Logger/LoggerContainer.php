<?php

namespace Deuzu\RequestCollectorBundle\Logger;

use Psr\Log\LoggerInterface;

/**
 * Contains a collection of loggers
 */
class LoggerContainer
{
    /**
     * @var array
     */
    private $loggers = [];

    /**
     * @param LoggerInterface $logger
     * @param string          $name
     *
     * @return void
     */
    public function add(LoggerInterface $logger, $name)
    {
        if (isset($this->loggers[$name])) {
            return;
        }

        $this->loggers[$name] = $logger;
    }

    /**
     * @param  string $name
     *
     * @return LoggerInterface|null
     */
    public function getByName($name)
    {
        return isset($this->loggers[$name]) ? $this->loggers[$name] : null;
    }
}
