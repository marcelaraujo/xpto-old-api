<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Recommendation;

use Xpto\Service\Queue\Mail as MailService;
use Xpto\Factory\Queue\Mail as MailFactory;
use Symfony\Component\EventDispatcher\Event;

/**
 * User event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class Approve
{
    /**
     * @var string
     */
    const NAME = 'recommendation.approve';

    /**
     * @var Application
     */
    private $app;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     *
     * @return void
     */
    public function dispatch(Event $event)
    {
        $this->app['monolog.default']->addDebug('executando chamada de ' . self::NAME);

        $content = $this->app['twig']
            ->render(
                'mail/recommendation.approve.twig',
                [
                    'name' => $this->app['recommendation']->getSource()->getName(),
                ]
            );

        $mail = MailFactory::create(
            $this->app['recommendation']->getSource()->getEmail(),
            sprintf(
                'Seu amigo %s aceitou sua recomendação',
                $this->app['recommendation']->getDestination()->getName()
            ),
            $content
        );

        $this->app[MailService::QUEUE_MAIL_INSERT]($mail);
    }
}
