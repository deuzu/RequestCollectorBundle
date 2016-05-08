<?php

namespace Deuzu\RequestCollectorBundle\Controller;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
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
        $requestObject = $this->get('deuzu.request_collector.request_provider')->createFromRequest($_collector);
        $requestCollectorParameters = $this->container->getParameter('deuzu_request_collector');
        $collectorParameters = $requestCollectorParameters['collectors'][$_collector];
        $this->get('deuzu.request_collector.collector.dispatcher')->dispatch($requestObject, $collectorParameters);

        $postCollectHandlerCollection = $this->get('deuzu.request_collector.post_collect_handler_collection');
        $postCollectHandler = $postCollectHandlerCollection->getPostCollectHandlerByName($_collector);
        $response = new Response(null, 200);

        if (null !== $postCollectHandler) {
            $response = $postCollectHandler->handle($requestObject);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param string  $_collector
     *
     * @return Response
     */
    public function inspectAction(Request $request, $_collector)
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('Cannot serve requests from database without doctrine enabled');
        }

        $page = $request->query->get('page', 1);
        $requestCollectorRepository = $this->getDoctrine()->getRepository(RequestObject::class);
        $requestCollectorParams = $this->container->getParameter('deuzu_request_collector');

        if (!isset($requestCollectorParams['collectors'][$_collector])) {
            throw new \InvalidArgumentException(sprintf('The collector named %s cannot be found in configuration', $_collector));
        }

        $paginator = $requestCollectorRepository->findByCollector(
            $_collector,
            $page,
            $requestCollectorParams['collectors'][$_collector]['items_per_page']
        );

        return $this->render(
            'DeuzuRequestCollectorBundle:RequestCollector:index.html.twig',
            [
                'paginator' => $paginator,
                'assets' => $requestCollectorParams['assets'],
                'page' => $page,
                'itemsPerPage' => $requestCollectorParams['collectors'][$_collector]['items_per_page'],
            ]
        );
    }
}
