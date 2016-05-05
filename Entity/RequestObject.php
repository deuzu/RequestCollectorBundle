<?php

namespace Deuzu\RequestCollectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Request
 *
 * @author Florian Touya <florian.touya@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Deuzu\RequestCollectorBundle\Repository\RequestCollectorRepository")
 * @ORM\Table(name="deuzu_request_collector_request")
 */
class RequestObject
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $headers;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $postParameters;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $queryParameters;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $collector;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2048)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $method;

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Sets the value of headers.
     *
     * @param array $headers the headers
     *
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Gets the value of postParameters.
     *
     * @return array
     */
    public function getPostParameters()
    {
        return unserialize($this->postParameters);
    }

    /**
     * Sets the value of postParameters.
     *
     * @param array $postParameters the post parameters
     *
     * @return self
     */
    public function setPostParameters(array $postParameters)
    {
        $this->postParameters = serialize($postParameters);

        return $this;
    }

    /**
     * Gets the value of queryParameters.
     *
     * @return array
     */
    public function getQueryParameters()
    {
        return unserialize($this->queryParameters);
    }

    /**
     * Sets the value of queryParameters.
     *
     * @param array $queryParameters the query parameters
     *
     * @return self
     */
    public function setQueryParameters(array $queryParameters)
    {
        $this->queryParameters = serialize($queryParameters);

        return $this;
    }

    /**
     * Gets the value of content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the value of content.
     *
     * @param mixed $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Gets the value of collector.
     *
     * @return string
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * Sets the value of collector.
     *
     * @param string $collector the collector
     *
     * @return self
     */
    public function setCollector($collector)
    {
        $this->collector = $collector;

        return $this;
    }

    /**
     * Gets the value of uri.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the value of uri.
     *
     * @param string $uri the uri
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Gets the value of collector.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets the value of method.
     *
     * @param string $method the method
     *
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHost()
    {
        $headers = $this->getHeaders();

        if (isset($headers['host']) && isset($headers['host'][0])) {
            return $headers['host'][0];
        }

        return null;
    }
}
