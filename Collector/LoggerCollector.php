<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Deuzu\RequestCollectorBundle\Logger\LoggerContainer;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class LoggerCollector.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class LoggerCollector implements CollectorInterface
{
    /**
     * @var LoggerContainer
     */
    private $loggerContainer;

    /**
     * @var LoggerInterface
     */
    private $deprecatedLogger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $logFolder;

    /**
     * @var string
     */
    private $kernelEnvironment;

    /**
     * @param SerializerInterface $serializer
     * @param LoggerContainer     $loggerContainer
     * @param LoggerInterface     $deprecatedLogger  deprecated
     * @param string              $logFolder         deprecated
     * @param string              $kernelEnvironment deprecated
     */
    public function __construct(
        SerializerInterface $serializer,
        LoggerContainer $loggerContainer,
        LoggerInterface $deprecatedLogger,
        $logFolder,
        $kernelEnvironment
    ) {
        $this->serializer = $serializer;
        $this->loggerContainer = $loggerContainer;
        $this->deprecatedLogger = $deprecatedLogger; // deprecated
        $this->logFolder = $logFolder; // deprecated
        $this->kernelEnvironment = $kernelEnvironment; // deprecated
    }

    /**
     * {@inheritdoc}
     */
    public function collect(RequestObject $requestObject, array $parameters = [])
    {
        if (!$parameters['logFile']) {
            $logger = $this->loggerContainer->getByName($parameters['channel']);
            $logger->info('request_collector.collect', $this->serializer->normalize($requestObject));
        } else {
            // deprecated
            $logFile = sprintf('%s/%s.%s', $this->logFolder, $this->kernelEnvironment, $parameters['logFile']);

            $this->deprecatedLogger->pushHandler(new StreamHandler($logFile));
            $this->deprecatedLogger->info('request_collector.collect', $this->serializer->normalize($requestObject));
        }
    }
}
