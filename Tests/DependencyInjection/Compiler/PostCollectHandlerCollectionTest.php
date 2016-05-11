<?php

namespace Deuzu\RequestCollectorBundle\Tests\DependencyInjection\Compiler;

use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\PostCollectHandlerCollection;
use Deuzu\RequestCollectorBundle\Tests\Fixtures\PostCollectHandler\CustomPostCollectHandler;

/**
 * Class PostCollectHandlerCollectionTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PostCollectHandlerCollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostCollectHandlerCollection */
    private $postCollectHandlerColection;

    /**
     * Setup
     */
    public function setup()
    {
        $this->postCollectHandlerColection = new PostCollectHandlerCollection();
    }

    /**
     * @test
     */
    public function itShouldAddPostHandlerToCollection()
    {
        $postCollectorHandler = new CustomPostCollectHandler();
        $this->postCollectHandlerColection->add($postCollectorHandler, 'test');
        $this->assertEquals($postCollectorHandler, $this->postCollectHandlerColection->getPostCollectHandlerByName('test'));
    }

    /**
     * @test
     * @expectedException \LogicException
     * @expectedExceptionMessageRegExp /A post collect handler named test already exists/
     */
    public function itShouldRaiseAnException()
    {
        $postCollectorHandler = new CustomPostCollectHandler();
        $this->postCollectHandlerColection->add($postCollectorHandler, 'test');
        $this->postCollectHandlerColection->add($postCollectorHandler, 'test');
    }
}
