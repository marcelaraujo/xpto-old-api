<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Media\Avatar;

use Symfony\Component\EventDispatcher\Event;

/**
 * Like a media post event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class PreCreate
{
    /**
     * @var string
     */
    const NAME = 'media.avatar.pre-create';

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
    }
}
