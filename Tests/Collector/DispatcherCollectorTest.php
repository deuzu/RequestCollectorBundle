<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

use Deuzu\RequestCollectorBundle\Collector\DispatcherCollector;
use Deuzu\RequestCollectorBundle\Collector\LoggerCollector;
use Deuzu\RequestCollectorBundle\Collector\MailerCollector;
use Deuzu\RequestCollectorBundle\Collector\PersisterCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Prophecy\Argument;

/**
 * Class DispatcherCollectorTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DispatcherCollectorTest extends \PHPUnit_Framework_TestCase
{
    /** @var LoggerCollector */
    private $logger;

    /** @var PersisterCollector */
    private $persister;

    /** @var MailerCollector */
    private $mailer;

    /**
     * Setup
     */
    public function setup()
    {
        $this->logger = $this->prophesize(LoggerCollector::class);
        $this->persister = $this->prophesize(PersisterCollector::class);
        $this->mailer = $this->prophesize(MailerCollector::class);
    }

    /**
     * @test
     * @dataProvider dispatcherDataProvider
     *
     * @param array $configuration
     */
    public function itShouldDipatch($configuration)
    {
        $dispatcher = new DispatcherCollector();
        $requestObject = new RequestObject();

        $dispatcher->setLoggerCollector($this->logger->reveal());
        $dispatcher->setPersisterCollector($this->persister->reveal());
        $dispatcher->setMailerCollector($this->mailer->reveal());

        if ($configuration['logger']['enabled']) {
            $this->logger->collect(Argument::type(RequestObject::class), Argument::type('array'))->shouldBeCalled();
        } else {
            $this->logger->collect(Argument::type(RequestObject::class), Argument::type('array'))->shouldNotBeCalled();
        }

        if ($configuration['persister']['enabled']) {
            $this->persister->collect(Argument::type(RequestObject::class))->shouldBeCalled();
        } else {
            $this->persister->collect(Argument::type(RequestObject::class))->shouldNotBeCalled();
        }

        if ($configuration['mailer']['enabled']) {
            $this->mailer->collect(Argument::type(RequestObject::class), Argument::type('array'))->shouldBeCalled();
        } else {
            $this->mailer->collect(Argument::type(RequestObject::class), Argument::type('array'))->shouldNotBeCalled();
        }

        $dispatcher->dispatch($requestObject, $configuration);
    }

    /**
     * @return array
     */
    public function dispatcherDataProvider()
    {
        $this->logger = $this->prophesize(LoggerCollector::class);
        $this->persister = $this->prophesize(PersisterCollector::class);
        $this->mailer = $this->prophesize(MailerCollector::class);

        $configuration = [
            'logger' => ['enabled' => true, 'channel' => 'test', 'file' => 'test'],
            'persister' => ['enabled' => true],
            'mailer' => ['enabled' => true, 'email' => 'to@deuzu.com'],
        ];

        $nullConfiguration = [
            'logger' => ['enabled' => false],
            'persister' => ['enabled' => false],
            'mailer' => ['enabled' => false],
        ];

        $onlyLogConfiguration = [
            'logger' => ['enabled' => true, 'channel' => 'test', 'file' => 'test'],
            'persister' => ['enabled' => false],
            'mailer' => ['enabled' => false],
        ];

        return [
            [$configuration],
            [$nullConfiguration],
            [$onlyLogConfiguration],
        ];
    }
}
