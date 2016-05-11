<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Class PersisterCollector.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PersisterCollector implements CollectorInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(RequestObject $requestObject, array $parameters = [])
    {
        $manager = $this->doctrine->getManager();
        $manager->persist($requestObject);
        $manager->flush();
    }
}
