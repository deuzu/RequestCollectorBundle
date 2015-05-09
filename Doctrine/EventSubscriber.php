<?php

namespace Deuzu\RequestCollectorBundle\Doctrine;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Deuzu\RequestCollectorBundle\Service\Mailer;
use Deuzu\RequestCollectorBundle\Event\Events;
use Deuzu\RequestCollectorBundle\Event\ObjectEvent;
use Monolog\Handler\StreamHandler;

/**
 * Class EventSubscriber
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class EventSubscriber implements EventSubscriberInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var LoggerInterface */
    private $loggger;

    /** @var Mailer */
    private $mailer;


    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param ObjectManager            $manager
     * @param LoggerInterface          $logger
     * @param Mailer                   $mailer
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, ManagerRegistry $managerRegistry, LoggerInterface $logger, Mailer $mailer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->managerRegistry = $managerRegistry;
        $this->logger          = $logger;
        $this->mailer          = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_PERSIST => ['persistRequest', 0],
            Events::PRE_LOG     => ['logRequest', 0],
            Events::PRE_MAIL    => ['mailRequest', 0]
        ];
    }

    /**
     * @param ObjectEvent $objectEvent
     */
    public function persistRequest(ObjectEvent $objectEvent)
    {
        $objectManager = $this->managerRegistry->getManagerForClass(get_class($objectEvent->getObject()));
        $objectManager->persist($objectEvent->getObject());
        $objectManager->flush();

        $this->eventDispatcher->dispatch(Events::POST_PERSIST, $objectEvent);
        $objectEvent->stopPropagation();
    }

    /**
     * @param ObjectEvent $objectEvent
     */
    public function logRequest(ObjectEvent $objectEvent)
    {
        $this->logger->pushHandler(new StreamHandler($objectEvent->getParams()['file']));
        $this->logger->info('request_collector.collect', $objectEvent->getObject()->toArray());

        $this->eventDispatcher->dispatch(Events::POST_LOG, $objectEvent);
        $objectEvent->stopPropagation();
    }

    /**
     * @param ObjectEvent $objectEvent
     */
    public function mailRequest(ObjectEvent $objectEvent)
    {
        $this->mailer->send($objectEvent->getObject(), $objectEvent->getParams()['email']);

        $this->eventDispatcher->dispatch(Events::POST_MAIL, $objectEvent);
        $objectEvent->stopPropagation();
    }
}
