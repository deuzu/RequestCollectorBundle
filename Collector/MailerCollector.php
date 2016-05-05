<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;
use Swift_Mailer;

/**
 * Class MailerCollector.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class MailerCollector implements CollectorInterface
{
    /** @var Swift_Mailer */
    private $mailer;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $fromEmail;

    /**
     * @param Swift_Mailer    $mailer
     * @param EngineInterface $templating
     * @param string          $fromEmail
     */
    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, array $requestCollectorConfiguration)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromEmail = $requestCollectorConfiguration['from_email'];
    }

    /**
     * {@inheritdoc}
     */
    public function collect(RequestObject $requestObject, array $parameters = [])
    {
        $parameters = $this->resolveCollectorParameters($parameters);
        $message = $this->mailer->createMessage()
            ->setSubject('Request collector')
            ->setFrom($this->fromEmail)
            ->setTo($parameters['email'])
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

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function resolveCollectorParameters(array $parameters = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['email']);

        return $resolver->resolve($parameters);
    }
}
