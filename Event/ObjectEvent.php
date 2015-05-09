<?php

namespace Deuzu\RequestCollectorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Deuzu\RequestCollectorBundle\Entity\Request;

/**
 * Class ObjectEvent
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class ObjectEvent extends Event
{
    /** @var Request */
    private $object;

    /** @var array */
    private $params;


    /**
     * @param Request $object
     * @param array $params
     */
    public function __construct(Request $object, array $params = [])
    {
        $this->object = $object;
        $this->params = $params;
    }

    /**
     * @return Request
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
