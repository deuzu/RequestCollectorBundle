<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

use Deuzu\RequestCollectorBundle\Collector\LoggerCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Deuzu\RequestCollectorBundle\Logger\LoggerContainer;
use Prophecy\Argument;
use Monolog\Logger;
use Symfony\Component\Serializer\Serializer;

/**
 * Class LoggerCollectorTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class LoggerCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerContainer
     */
    private $loggerContainer;

    /**
     * @var Logger
     */
    private $deprecatedLogger;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var RequestObject
     */
    private $requestObject;

    /**
     * @var LoggerCollector
     */
    private $collector;

    /**
     * Setup
     */
    public function setup()
    {
        $this->loggerContainer = $this->prophesize(LoggerContainer::class);
        $this->deprecatedLogger = $this->prophesize(Logger::class);
        $this->serializer = $this->prophesize(Serializer::class);
        $logFolder = '.';
        $kernelEnvironment = 'test';
        $this->requestObject = new RequestObject();

        $this->collector = new LoggerCollector(
            $this->serializer->reveal(),
            $this->loggerContainer->reveal(),
            $this->deprecatedLogger->reveal(),
            $logFolder,
            $kernelEnvironment
        );
    }

    /**
     * @test
     */
    public function itShouldCollect()
    {
        $logger = $this->prophesize(Logger::class);
        $this->loggerContainer->getByName('test')->willReturn($logger->reveal());
        $this->serializer->normalize(Argument::any())->willReturn(['whatever' => true]);
        $logger->info('request_collector.collect', ['whatever' => true]);

        $this->serializer->normalize(Argument::any())->willReturn([]);
        $this->deprecatedLogger->pushHandler(Argument::any())->shouldBeCalled();
        $this->deprecatedLogger->info(Argument::type('string'), [])->shouldBeCalled();
        $this->collector->collect($this->requestObject, ['logFile' => 'test.log', 'channel' => 'test']);
    }
}
