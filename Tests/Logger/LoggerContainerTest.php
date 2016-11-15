<?php

namespace Deuzu\RequestCollectorBundle\Tests\Logger;

use Deuzu\RequestCollectorBundle\Logger\LoggerContainer;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerContainerTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class LoggerContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->loggerContainer = new LoggerContainer();
    }

    /**
     * @test
     */
    public function itShouldAddALogger()
    {
        $logger = $this->prophesize(LoggerInterface::class)->reveal();

        $this->loggerContainer->add($logger, 'logger_test');

        $this->assertSame($this->loggerContainer->getByName('logger_test'), $logger);
    }

    /**
     * @test
     */
    public function itShouldReturnNullIfMissingLogger()
    {
        $logger = $this->prophesize(LoggerInterface::class)->reveal();

        $this->loggerContainer->add($logger, 'logger_test');

        $this->assertNotSame($this->loggerContainer->getByName('nonexisting_logger'), $logger);
    }
}
