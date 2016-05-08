<?php

namespace Deuzu\RequestCollectorBundle\Routing;

/**
 * Class RouteCollectorLoaderTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RouteCollectorLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var RouteCollectorLoader */
    private $routeLoader;

    /** @var array */
    private $configuration;

    /**
     * Setup
     */
    public function setup()
    {
        $this->configuration = [
            'collectors' => [
                'test' => ['route_path' => '/test', 'logger' => ['enabled' => true, 'file' => 'test.log']],
                'test2' => ['route_path' => '/test2', 'persister' => ['enabled' => true]],
            ],
        ];
        $this->routeLoader = new RouteCollectorLoader($this->configuration);
    }
    /**
     * @test
     */
    public function itShouldLoadRoutes()
    {
        $routeCollection = $this->routeLoader->load($this->configuration);

        $this->assertCount(count($this->configuration['collectors']) * 2, $routeCollection);
    }

    /**
     * @test
     */
    public function itShouldSupport()
    {
        $this->assertTrue($this->routeLoader->supports(null, 'request_collector'));
        $this->assertFalse($this->routeLoader->supports(null, 'default'));
    }
}
