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
     * @param string  $_collectorName
     *
     * @return Response
     */
    public function collectAction(Request $request, $_collectorName)
    {
        $eventDispatcher            = $this->get('event_dispatcher');
        $requestCollectorRepository = $this->get('deuzu.request_collector.repository');
        $requestCollectorParams     = $this->container->getParameter('deuzu_request_collector');
        $requestObject              = $requestCollectorRepository->createFromRequest($request);

        if (!isset($requestCollectorParams['collector'][$_collectorName])) {
            throw new \InvalidArgumentException(sprintf('The collector named %s cannot be found in configuration', $_collectorName));
        }

        $collectorParams = $requestCollectorParams['collector'][$_collectorName];

        if (true === $collectorParams['persist']['enabled']) {
            $eventDispatcher->dispatch(Events::PRE_PERSIST, new ObjectEvent($requestObject));
        }

        if (true === $collectorParams['log']['enabled']) {
            $eventDispatcher->dispatch(Events::PRE_LOG, new ObjectEvent($requestObject));
        }

        if (true === $collectorParams['mail']['enabled']) {
            $eventDispatcher->dispatch(
                Events::PRE_MAIL,
                new ObjectEvent($requestObject, ['email' => $collectorParams['mail']['email']])
            );
        }

        $postCollectHandlerCollection = $this->get('deuzu.request_collector.post_collect_handler_collection');
        $postCollectHandler           = $postCollectHandlerCollection->getPostCollectHandlerByName($_collectorName);

        $response = null;
        
        if (null !== $postCollectHandler) {
            $response = $postCollectHandler->execute($requestObject);
        }

        return $response instanceof Response ? $response : new Response(null, 200);
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $requestCollectorRepository = $this->get('deuzu.request_collector.repository');
        $requestCollectorParams     = $this->container->getParameter('deuzu_request_collector');
        $requestObjects             = $requestCollectorRepository->findAll();
        $template                   = 'DeuzuRequestCollectorBundle:RequestCollector:index.html.twig';
        $templateParams             = ['requestObjects' => $requestObjects];

        if (null !== $requestCollectorParams['bootstrap3']) {
            $templateParams['bootstrap3'] = $requestCollectorParams['bootstrap3'];
        }

        return $this->render($template, $templateParams);
    }
}
