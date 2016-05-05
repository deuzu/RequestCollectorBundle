<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
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
    /** @var LoggerInterface */
    private $logger;

    /** @var SerializerInterface */
    private $serializer;

    /** @var string */
    private $logFolder;

    /** @var string */
    private $kernelEnvironment;

    /**
     * @param LoggerInterface     $logger
     * @param SerializerInterface $serializer
     * @param string              $logFolder
     * @param string              $kernelEnvironment
     */
    public function __construct(LoggerInterface $logger, SerializerInterface $serializer, $logFolder, $kernelEnvironment)
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->logFolder = $logFolder;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(RequestObject $requestObject, array $parameters = [])
    {
        $parameters = $this->resolveCollectorParameters($parameters);
        $logFile = sprintf('%s/%s.%s', $this->logFolder, $this->kernelEnvironment, $parameters['logFile']);

        $this->logger->pushHandler(new StreamHandler($logFile));
        $this->logger->info('request_collector.collect', $this->serializer->normalize($requestObject));
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function resolveCollectorParameters(array $parameters = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['logFile']);

        return $resolver->resolve($parameters);
    }
}
