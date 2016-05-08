<?php

namespace Deuzu\RequestCollectorBundle\Request;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestObjectProvider.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RequestObjectProvider
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param string $collectorName
     *
     * @return RequestObject
     */
    public function createFromRequest($collectorName)
    {
        $requestObject = new RequestObject();
        $requestObject->setHeaders($this->request->headers->all());
        $requestObject->setPostParameters($this->request->request->all());
        $requestObject->setQueryParameters($this->request->query->all());
        $requestObject->setContent($this->request->getContent());
        $requestObject->setCollector($collectorName);
        $requestObject->setUri($this->request->getUri());
        $requestObject->setMethod($this->request->getMethod());

        return $requestObject;
    }
}
