<?php

namespace Deuzu\RequestCollectorBundle\Tests\Request;

use Deuzu\RequestCollectorBundle\Request\RequestObjectProvider;
use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestObjectProviderTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class RequestObjectProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldProvideARequestObjet()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $requestStack->getCurrentRequest()->willReturn(Request::createFromGlobals());
        $requestObjectProvider = new RequestObjectProvider($requestStack->reveal());
        $requestObject = $requestObjectProvider->createFromRequest('test_collector');

        $this->assertInstanceOf(RequestObject::class, $requestObject);
    }
}
