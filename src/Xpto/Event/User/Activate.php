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
 * User event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class Activate
{
    /**
     * @var string
     */
    const NAME = 'user.activate';

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
    public function dispatch(Event $event)
    {
        $this->app['monolog.default']
            ->addDebug('executando chamada de ' . self::NAME);

        $content = $this->app['twig']
            ->render(
                'mail/user.activate.twig',
                [
                    'name' => $this->app['profile']->getUser()->getName(),
                ]
            );

        $mail = \Xpto\Factory\Queue\Mail::create(
            $this->app['profile']->getUser()->getEmail(),
            'Conta ativada',
            $content
        );

        (new MailService($this->app['orm.em']))->save($mail);
    }
}
