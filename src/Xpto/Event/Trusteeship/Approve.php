<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Trusteeship;

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
    const NAME = 'trusteeship.approve';

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
        $this->app['monolog.default']->addDebug('executando chamada de ' . self::NAME);

        $content = $this
            ->app['twig']
            ->render(
                'mail/user.approve.twig',
                [
                    'name' => $this->app['profile']->getUser()->getName()
                ]
            );

        $mail = \Xpto\Factory\Queue\Mail::create(
            $this->app['profile']->getUser()->getEmail(),
            'Conta aprovada',
            $content
        );

        $this->app['orm.em']->persist($mail);
        $this->app['orm.em']->flush();
    }
}
