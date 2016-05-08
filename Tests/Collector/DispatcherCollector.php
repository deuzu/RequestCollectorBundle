<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

/**
 * Class DispatcherCollectorTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DispatcherCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldDipatch()
    {
        $dispatcher = new DispatcherCollector();
    }
}
