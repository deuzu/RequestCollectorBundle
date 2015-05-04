<?php

namespace Deuzu\RequestCollectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
            'headers'         => $this->getHeaders(),
            'postParameters'  => $this->getPostParameters(),
            'queryParameters' => $this->getQueryParameters(),
            'content'         => $this->getContent(),
            'createdAt'       => $this->getCreatedAt()->format('d/m/Y H:i:s')
        ];
    }
}
