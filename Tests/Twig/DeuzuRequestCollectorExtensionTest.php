<?php

namespace Deuzu\RequestCollectorBundle\Twig;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;

/**
 * Class DeuzuRequestCollectorExtensionTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DeuzuRequestCollectorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var DeuzuRequestCollectorExtension */
    private $twigExtension;

    /**
     * Setup
     */
    public function setup()
    {
        $this->twigExtension = new DeuzuRequestCollectorExtension();
    }
    /**
     * @test
     */
    public function itShouldGetFilters()
    {
        $this->assertCount(2, $this->twigExtension->getFilters());
    }

    /**
     * @test
     */
    public function itShouldGetName()
    {
        $this->assertEquals('deuzu_requestcollector_extension', $this->twigExtension->getName());
    }

    /**
     * @test
     */
    public function itShouldFormatParameters()
    {
        $expectedFormatedParameters = ['category' => 'tennis', 'enabled' => true, 'media[image1]' => 'image1.jpg'];
        $parameters = ['category' => 'tennis', 'enabled' => true, 'media' => ['image1' => 'image1.jpg']];
        $formatedParameters = $this->twigExtension->formatParameters($parameters);

        $this->assertEquals($expectedFormatedParameters, $formatedParameters);
    }

    /**
     * @test
     */
    public function itShouldTransformARequestForCurl()
    {
        $host = 'http://www.deuzu.com/';
        $postParameters = [
            'category' => 'tennis',
            'enabled' => true,
        ];
        $headers = [
            'Host' => ['deuzu.com'],
            'Content-Type' => ['image/jpg'],
        ];
        $requestObject = new RequestObject();
        $requestObject->setHeaders($headers);
        $requestObject->setPostParameters($postParameters);
        $requestObject->setUri($host);

        $expectedCurlHeaders = '--header "Host: deuzu.com" --header "Content-Type: image/jpg"';
        $expectedCurlPostParameters = '--data "category=tennis&enabled=1"';
        $expectedCurlRequest = sprintf('curl %s %s %s', $expectedCurlHeaders, $expectedCurlPostParameters, $host);

        $this->assertEquals($expectedCurlRequest, $this->twigExtension->requestToCurl($requestObject));
    }
}
