<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

use Deuzu\RequestCollectorBundle\Collector\MailerCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Bridge\Twig\TwigEngine;
use Swift_Mailer;

/**
 * Class MailerCollectorTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class MailerCollectorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Logger */
    private $logger;

    /** @var Serializer */
    private $serializer;

    /** @var RequestObject */
    private $requestObject;

    /** @var LoggerCollector */
    private $collector;

    /**
     * Setup
     */
    public function setup()
    {
        $this->mailer = $this->prophesize(Swift_Mailer::class);
        $this->templating = $this->prophesize(TwigEngine::class);
        $requestCollectorConfiguration = ['from_email' => 'from@deuzu.com'];
        $this->requestObject = new RequestObject();

        $this->collector = new MailerCollector(
            $this->mailer->reveal(),
            $this->templating->reveal(),
            $requestCollectorConfiguration
        );
    }
    /**
     * @test
     */
    public function itShouldCollect()
    {
        $message = new \Swift_Message();
        $this->mailer->createMessage()->willReturn($message);
        $this->mailer->send($message)->shouldBeCalled();
        $this->collector->collect($this->requestObject, ['email' => 'to@deuzu.com']);
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
