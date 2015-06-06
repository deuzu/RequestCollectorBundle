<?php

namespace Deuzu\RequestCollectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Deuzu\RequestCollectorBundle\Event\Events;
use Deuzu\RequestCollectorBundle\Event\ObjectEvent;

/**
 * Class DefaultController
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @param string  $_collector
     *
     * @return Response
     */
    public function collectAction(Request $request, $_collector)
    {
        $eventDispatcher            = $this->get('event_dispatcher');
        $requestCollectorRepository = $this->get('deuzu.request_collector.repository');
        $requestCollectorParams     = $this->container->getParameter('deuzu_request_collector');
        $requestObject              = $requestCollectorRepository->createFromRequest($request, $_collector);

        if (!isset($requestCollectorParams['collectors'][$_collector])) {
            throw new \InvalidArgumentException(sprintf('The collector named %s cannot be found in configuration', $_collector));
        }

        $collectorParams = $requestCollectorParams['collectors'][$_collector];

        if (true === $collectorParams['persist']['enabled']) {
            $eventDispatcher->dispatch(Events::PRE_PERSIST, new ObjectEvent($requestObject));
        }

        if (true === $collectorParams['log']['enabled']) {
            $logFile = sprintf(
                '%s/%s.%s',
                $this->container->getParameter('kernel.logs_dir'),
                $this->container->getParameter('kernel.environment'),
                $collectorParams['log']['file']
            );

            $eventDispatcher->dispatch(
                Events::PRE_LOG,
                new ObjectEvent($requestObject, ['file' => $logFile])
            );
        }

        if (true === $collectorParams['mail']['enabled']) {
            $eventDispatcher->dispatch(
                Events::PRE_MAIL,
                new ObjectEvent($requestObject, ['email' => $collectorParams['mail']['email']])
            );
        }

        $postCollectHandlerCollection = $this->get('deuzu.request_collector.post_collect_handler_collection');
        $postCollectHandler           = $postCollectHandlerCollection->getPostCollectHandlerByName($_collector);
        $response                     = null;

        if (null !== $postCollectHandler) {
            $response = $postCollectHandler->execute($requestObject);
        }

        return $response instanceof Response ? $response : new Response(null, 200);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function inspectAction(Request $request, $_collector)
    {
        $page                       = $request->query->get('page', 1);
        $requestCollectorRepository = $this->get('deuzu.request_collector.repository');
        $requestCollectorParams     = $this->container->getParameter('deuzu_request_collector');

        if (!isset($requestCollectorParams['collectors'][$_collector])) {
            throw new \InvalidArgumentException(sprintf('The collector named %s cannot be found in configuration', $_collector));
        }

        $requestObjects = $requestCollectorRepository->findByCollector(
            $_collector,
            $page,
            $requestCollectorParams['collectors'][$_collector]['item_per_page']
        );

        return $this->render(
            'DeuzuRequestCollectorBundle:RequestCollector:index.html.twig',
            [
                'requestObjects' => $requestObjects,
                'assets'         => $requestCollectorParams['assets']
            ]
        );
    }
}
