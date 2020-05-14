<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\User;

use Xpto\Service\Queue\Mail as MailService;
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
    const NAME = 'user.create';

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
     * Execute listener
     *
     * @return void
     */
    public function dispatch(Event $event)
    {
        $this->app['monolog.default']->addDebug('executando chamada de ' . self::NAME);

        $content = $this->app['twig']
            ->render(
                'mail/user.create.twig',
                [
                    'name' => $this->app['profile']->getUser()->getName(),
                ]
            );

        $mail = \Xpto\Factory\Queue\Mail::create(
            $this->app['profile']->getUser()->getEmail(),
            'Bem vindo',
            $content
        );

        $this->app['orm.em']->persist($mail);
        $this->app['orm.em']->flush();

        $this->app['media.album']->createDefaultForUser($this->app['profile']->getUser());
    }
}
