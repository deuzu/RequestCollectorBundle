<?php

namespace Deuzu\RequestCollectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Deuzu\RequestCollectorBundle\Entity\Request as RequestObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestCollectorRepository
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RequestCollectorRepository extends EntityRepository
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

    /**
     * @param RequestObject $requestObject
     * @param bolean        $doFlush
     */
    public function persist(RequestObject $requestObject, $doFlush = false)
    {
        $this->_em->persist($requestObject);

        if ($doFlush) {
            $this->_em->flush();
        }
    }
}
