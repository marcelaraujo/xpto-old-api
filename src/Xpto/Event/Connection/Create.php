<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Connection;

use Xpto\Service\Notifications\Notification as NotificationService;
use Xpto\Service\Queue\Mail as MailService;
use Xpto\Factory\Queue\Mail as MailFactory;
use Xpto\Factory\Notifications\Info as NotificationFactory;
use Symfony\Component\EventDispatcher\Event;

/**
 * Connection created event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class Create
{
    /**
     * @var string
     */
    const NAME = 'connection.create';

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Application
     */
    private $app;

    /**
     * Constructor
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Execute listener
     *
     * @param Event $event
     * @return void
     */
    public function dispatch(Event $event)
    {
        $mail = MailFactory::create(
            $this->app['connection']->getDestination()->getEmail(),
            'Pedido de conexão solicitado',
            $this->app['twig']->render(
                'mail/connection.create.twig',
                [
                    'name' => $this->app['connection']->getDestination()->getName(),
                ]
            )
        );

        $message = sprintf(
            '%s deseja adicionar você a sua lista de contatos',
            $this->app['connection']->getDestination()->getName()
        );

        $notification = NotificationFactory::create($this->app['user'], $message);

        $this->app[MailService::QUEUE_MAIL_INSERT]($mail);
        $this->app[NotificationService::NOTIFICATION]->save($notification);
    }
}
