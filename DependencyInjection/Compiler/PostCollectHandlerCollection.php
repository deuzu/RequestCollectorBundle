<?php

namespace Deuzu\RequestCollectorBundle\DependencyInjection\Compiler;

use Deuzu\RequestCollectorBundle\PostCollectHandler\PostCollectHandlerInterface;

/**
 * Class PostCollectHandlerCollection.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PostCollectHandlerCollection
{
    /** @var array */
    private $postCollectHandlerIndex = [];

    /**
     * @param AbstractPostCollectHandler $postCollector
     * @param string                     $postCollectHandlerName
     */
    public function add(PostCollectHandlerInterface $postCollector, $postCollectHandlerName)
    {
        if (isset($this->postCollectHandlerIndex[$postCollectHandlerName])) {
            throw new \LogicException(sprintf('A post collect handler named %s already exists.', $postCollectHandlerName));
        }

        $this->postCollectHandlerIndex[$postCollectHandlerName] = $postCollector;
    }

    /**
     * @param string $name
     *
     * @return AbstractPostCollectHandler|null
     */
    public function getPostCollectHandlerByName($name)
    {
        return isset($this->postCollectHandlerIndex[$name]) ? $this->postCollectHandlerIndex[$name] : null;
    }
}
