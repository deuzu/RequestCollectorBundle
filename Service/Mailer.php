<?php

namespace Deuzu\RequestCollectorBundle\Service;

use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface;
use Deuzu\RequestCollectorBundle\Entity\Request as RequestObject;

/**
 * Class Mailer
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class Mailer
{
    /** @var Swift_Mailer */
    private $mailer;

    /** @var EngineInterface */
    private $templating;


    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param RequestObject $requestObject
     * @param string        $to
     */
    public function send(RequestObject $requestObject, $to)
    {
        $message = $this->mailer->createMessage()
            ->setSubject('Request collector')
            ->setFrom('todo@todo.fr')
            ->setTo($to)
            ->setBody(
                $this->templating->render(
                    'DeuzuRequestCollectorBundle:Mail:requestCollector.html.twig',
                    ['requestObject' => $requestObject]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}
