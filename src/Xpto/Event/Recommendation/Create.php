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
 * Connection created event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class Create
{
    /**
     * @var string
     */
    const NAME = 'recommendation.create';

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
                'mail/recommendation.create.twig',
                [
                    'name' => $this->app['recommendation']->getDestination()->getName(),
                ]
            );

        $mail = MailFactory::create(
            $this->app['recommendation']->getDestination()->getEmail(),
            sprintf(
                'Seu amigo %s criou uma recomendação para você',
                $this->app['recommendation']->getSource()->getName()
            ),
            $content
        );

        $this->app[MailService::QUEUE_MAIL_INSERT]($mail);
    }
}
