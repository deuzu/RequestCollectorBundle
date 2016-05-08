<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Collector\LoggerCollector;
use Deuzu\RequestCollectorBundle\Collector\MailerCollector;
use Deuzu\RequestCollectorBundle\Collector\PersisterCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;

/**
 * Class DispatcherCollector.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DispatcherCollector
{
    /**
     * @var LoggerCollector
     */
    private $loggerCollector;

    /**
     * @var PersisterCollector
     */
    private $persisterCollector;

    /**
     * @var MailerCollector
     */
    private $mailerCollector;

    /**
     * @param LoggerCollector|null $logger
     */
    public function setLoggerCollector(LoggerCollector $loggerCollector = null)
    {
        $this->loggerCollector = $loggerCollector;
    }

    /**
     * @param PersisterCollector|null $persisterCollector
     */
    public function setPersisterCollector(PersisterCollector $persisterCollector = null)
    {
        $this->persisterCollector = $persisterCollector;
    }

    /**
     * @param MailerCollector|null $mailerCollector
     */
    public function setMailerCollector(MailerCollector $mailerCollector = null)
    {
        $this->mailerCollector = $mailerCollector;
    }

    /**
     * @param RequestObject $requestObject
     * @param array         $collectorParameters
     */
    public function dispatch(RequestObject $requestObject, array $collectorParameters)
    {
        if (true === $collectorParameters['logger']['enabled']) {
            $this->loggerCollector->collect($requestObject, ['logFile' => $collectorParameters['logger']['file']]);
        }

        if (true === $collectorParameters['persister']['enabled']) {
            $this->persisterCollector->collect($requestObject);
        }

        if (true === $collectorParameters['mailer']['enabled']) {
            $this->mailerCollector->collect($requestObject, ['email' => $collectorParameters['mailer']['email']]);
        }
    }
}
