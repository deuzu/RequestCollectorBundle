<?php

namespace Deuzu\RequestCollectorBundle\Tests\Collector;

use Deuzu\RequestCollectorBundle\Collector\PersisterCollector;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Doctrine\ORM\EntityManager;
use Prophecy\Argument;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Class PersisterCollectorTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PersisterCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCollect()
    {
        $doctrine = $this->prophesize(ManagerRegistry::class);
        $entityManager = $this->prophesize(EntityManager::class);
        $doctrine->getManager()->willReturn($entityManager->reveal());
        $requestObject = new RequestObject();
        $collector = new PersisterCollector($doctrine->reveal());

        $entityManager->persist($requestObject)->shouldBecalled();
        $entityManager->flush()->shouldBecalled();
        $collector->collect($requestObject);
    }
}
