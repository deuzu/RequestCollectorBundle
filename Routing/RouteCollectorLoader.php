<?php

namespace Deuzu\RequestCollectorBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/**
 * Class RouteCollectorLoader.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RouteCollectorLoader extends Loader
{
    /** Route name prefix */
    const ROUTE_NAME_PREFIX = 'request_collector';

    /** Default controller shortcut */
    const DEFAULT_CONTROLLER = 'DeuzuRequestCollectorBundle:Default';

    /** Type of the loader */
    const TYPE = 'request_collector';

    /** @var array */
    private $requestCollectorConfiguration;

    /**
     * @param array $requestCollectorConfiguration
     */
    public function __construct(array $requestCollectorConfiguration)
    {
        $this->requestCollectorConfiguration = $requestCollectorConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $type = null)
    {
        $routeCollection = new RouteCollection();

        foreach ($this->requestCollectorConfiguration['collectors'] as $collector => $collectorConfig) {
            $collectRoute = new Route(
                $collectorConfig['route_path'],
                [
                    '_controller' => sprintf('%s:collect', self::DEFAULT_CONTROLLER),
                    '_collector' => $collector,
                ]
            );

            $inspectPath = substr($collectorConfig['route_path'], -1) === '/' ? 'inspect' : '/inspect';
            $inspectRoute = new Route(
                $collectorConfig['route_path'].$inspectPath,
                [
                    '_controller' => sprintf('%s:inspect', self::DEFAULT_CONTROLLER),
                    '_collector' => $collector,
                ],
                [],
                [],
                '',
                [],
                ['GET']
            );

            $routeCollection->add(sprintf('%s_%s_%s', self::ROUTE_NAME_PREFIX, $collector, 'collect'), $collectRoute);
            $routeCollection->add(sprintf('%s_%s_%s', self::ROUTE_NAME_PREFIX, $collector, 'inspect'), $inspectRoute);
        }

        return $routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return self::TYPE === $type;
    }
}
