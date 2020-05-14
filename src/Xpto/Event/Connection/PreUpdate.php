<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Connection;

use Xpto\Repository\Connections\Connection as ConnectionRepository;
use InvalidArgumentException;
use Symfony\Component\EventDispatcher\Event;

/**
 * User event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class PreUpdate
{
    /**
     * @var string
     */
    const NAME = 'connection.pre-update';

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
    public function dispatch()
    {
        $this->app['monolog.default']
            ->addDebug('executando chamada de ' . self::NAME);

        $id = $this->app['request']->get('id');

        /* @var $repo \Xpto\Repository\Connections\Connection */
        $repo = new ConnectionRepository($this->app['orm.em']);

        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $repo->findById($id);

        if ($connection->getSource()->getId() !== $this->app['user']->getId()
            && $connection->getDestination()->getId() !== $this->app['user']->getId()
        ) {
            throw new InvalidArgumentException('You can not modify connections from others');
        }
    }
}
