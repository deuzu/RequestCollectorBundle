<?php

namespace Deuzu\RequestCollectorBundle\Twig;

use Deuzu\RequestCollectorBundle\Entity\Request as RequestObject;

class DeuzuRequestCollectorExtension extends \Twig_extension
{
    /** @var array */
    private $formatedParameters = [];


    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('formatParameters', array($this, 'formatParameters')),
            new \Twig_SimpleFilter('curl', array($this, 'requestToCurl')),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deuzu_requestcollector_extension';
    }

    /**
     * @param array $headers
     *
     * @return string
     */
    public function headersToCurl(array $headers)
    {
        $this->formatedParameters = [];
        $curlHeaders              = '';

        foreach ($headers as $headerName => $values) {
            foreach ($values as $headerValue) {
                $curlHeaders .= sprintf('--header "%s: %s" ', $headerName, $headerValue);
            }
        }

        return substr($curlHeaders, 0 , -1);
    }

    /**
     * @param array $postParameters
     *
     * @return string
     */
    public function postParametersToCurl(array $postParameters)
    {
        $this->formatedParameters = [];
        $curlPostParameters       = '--data "';

        foreach ($this->formatParameters($postParameters) as $key => $value) {
            $curlPostParameters .= sprintf('%s=%s&', $key, $value);
        }

        return substr($curlPostParameters, 0 , -1) . '"';
    }

    /**
     * @param array       $parameters
     * @param sitrng|null $keyString
     * @param boolean     $nested
     *
     * @return array
     */
    public function formatParameters(array $parameters, $keyString = null, $nested = false)
    {
        foreach ($parameters as $key => $value) {
            if (null !== $keyString && true === $nested) {
                $keyString = sprintf('%s[%s]', $keyString, $key);
            } else {
                $keyString = $key;
            }

            if (is_array($value)) {
                $this->formatParameters($value, $keyString, true);

                continue;
            } else {
                $this->formatedParameters[$keyString] = $value;
            }
        }

        return $this->formatedParameters;
    }

    /**
     * @param RequestObject $requestObject
     *
     * @return string
     */
    public function requestToCurl(RequestObject $requestObject)
    {
        return sprintf(
            'curl %s %s %s',
            $this->headersToCurl($requestObject->getHeaders()),
            $this->postParametersToCurl($requestObject->getPostParameters()),
            $requestObject->getUri()
        );
    }
}
