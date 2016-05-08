<?php

namespace Deuzu\RequestCollectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Deuzu\RequestCollectorBundle\Entity\Request as RequestObject;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class RequestCollectorRepository
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RequestCollectorRepository extends EntityRepository
{
    /**
     * @param string $collector
     * @param int    $page
     * @param int    $maxItemPerPage
     *
     * @return Paginator
     */
    public function findByCollector($collector, $page, $maxItemPerPage)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->where('c.collector = :collector')
            ->setParameter('collector', $collector)
            ->getQuery()
        ;

        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($maxItemPerPage * ($page - 1))
            ->setMaxResults($maxItemPerPage)
        ;

        return $paginator;
    }
}
