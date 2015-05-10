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
class Request
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $headers;

    /**
     * @var array
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $postParameters;

    /**
     * @var array
     *
     * @ORM\Column(type="text", nullable=true)
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
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $method;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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
        return unserialize($this->headers);
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
        $this->headers = serialize($headers);

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
     * Gets the value of url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the value of url.
     *
     * @param string $url the url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * Gets the value of createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the value of createdAt.
     *
     * @param \DateTime $createdAt the created at
     *
     * @return self
     */
    private function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'collector'       => $this->getCollector(),
            'method'          => $this->getMethod(),
            'url'             => $this->getUrl(),
            'headers'         => $this->getHeaders(),
            'postParameters'  => $this->getPostParameters(),
            'queryParameters' => $this->getQueryParameters(),
            'content'         => $this->getContent(),
            'createdAt'       => $this->getCreatedAt()->format('d/m/Y H:i:s')
        ];
    }
}
