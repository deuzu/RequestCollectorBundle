<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

use Deuzu\RequestCollectorBundle\Collector\LoggerCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
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
    /** @var Logger */
    private $logger;

    /** @var Serializer */
    private $serializer;

    /** @var RequestObject */
    private $requestObject;

    /** @var LoggerCollector */
    private $collector;

    public function setup()
    {
        $this->logger = $this->prophesize(Logger::class);
        $this->serializer = $this->prophesize(Serializer::class);
        $logFolder = '.';
        $kernelEnvironment = 'test';
        $this->requestObject = new RequestObject();

        $this->collector = new LoggerCollector(
            $this->logger->reveal(),
            $this->serializer->reveal(),
            $logFolder,
            $kernelEnvironment
        );
    }
    /**
     * @test
     */
    public function itShouldCollect()
    {
        $this->serializer->normalize(Argument::any())->shouldBeCalled()->willReturn([]);
        $this->logger->pushHandler(Argument::any())->shouldBeCalled()->willReturn(true);
        $this->logger->info(Argument::type('string'), Argument::type('array'))->shouldBeCalled();
        $this->collector->collect($this->requestObject, ['logFile' => 'test.log']);
    }

    /**
     * @test
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function itShouldThrowAnException()
    {
        $this->collector->collect($this->requestObject, []);
    }
}
