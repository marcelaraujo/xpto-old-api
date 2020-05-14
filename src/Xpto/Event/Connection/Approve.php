<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Connection;

use Domain\Value\NotificationType;
use Xpto\Entity\Notifications\Notification as NotificationModel;
use Xpto\Service\Notifications\Notification as NotificationService;
use Xpto\Service\Queue\Mail as MailService;
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
    const NAME = 'connection.approve';

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
    public function dispatch($profile)
    {
        $this->app['monolog.default']->addDebug('executando chamada de ' . self::NAME);

        $content = $this->app['twig']
            ->render(
                'mail/connection.approve.twig',
                [
                    'name' => $this->app['connection']->getDestination()->getName(),
                ]
            );

        $mail = \Xpto\Factory\Queue\Mail::create(
            $this->app['connection']->getDestination()->getEmail(),
            'Recomendação aprovada',
            $content
        );

        $message = sprintf(
            '%s aprovou seu pedido de conexão',
            $this->app['connection']->getDestination()->getName()
        );

        $notification = new NotificationModel;
        $notification->setContent($message);
        $notification->setStatus(NotificationModel::NEWER);
        $notification->setType(NotificationType::INFO);
        $notification->setUser($this->app['user']);

        $this->app[MailService::QUEUE_MAIL_INSERT]($mail);
        $this->app[NotificationService::NOTIFICATION]->save($notification);
    }
}
