<?php

namespace Deuzu\Bundle\RequestCollectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Deuzu\Bundle\RequestCollectorBundle\Entity\Request as RequestObject;
use Symfony\Component\HttpFoundation\Request;

class RequestCollectorRepository extends EntityRepository
{
    /**
     * @param Request $request
     *
     * @return RequestObject
     */
    public function createFromRequest(Request $request)
    {
        $requestObject = new RequestObject();
        $requestObject->setHeaders($request->headers->all());
        $requestObject->setPostParameters($request->request->all());
        $requestObject->setQueryParameters($request->query->all());
        $requestObject->setContent($request->getContent());

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
