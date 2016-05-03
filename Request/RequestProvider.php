<?php

namespace Deuzu\RequestCollectorBundle\Request;

use Symfony\Component\HttpFoundation\Request;
use Deuzu\RequestCollectorBundle\Entity\Request as RequestObject;

class RequestProvider
{
    /**
     * @param Request $request
     * @param string  $collectorName
     *
     * @return RequestObject
     */
    public function createFromRequest(Request $request, $collectorName)
    {
        $requestObject = new RequestObject();
        $requestObject->setHeaders($request->headers->all());
        $requestObject->setPostParameters($request->request->all());
        $requestObject->setQueryParameters($request->query->all());
        $requestObject->setContent($request->getContent());
        $requestObject->setCollector($collectorName);
        $requestObject->setUri($request->getUri());
        $requestObject->setMethod($request->getMethod());

        return $requestObject;
    }
}
