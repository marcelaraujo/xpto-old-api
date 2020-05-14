<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Recommendation;

use Xpto\Repository\Recommendations\Recommendation as RecommendationRepository;
use InvalidArgumentException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Recommendatino pre-approve event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class PreDelete
{
    /**
     * @var string
     */
    const NAME = 'recommendation.pre-delete';

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

        $id = $this->app['request']->get('id');

        /* @var $repo \Xpto\Repository\Recommendations\Recommendation */
        $repo = new RecommendationRepository($this->app['orm.em']);

        /* @var $recommendation \Xpto\Entity\Recommendations\Recommendation */
        $recommendation = $repo->findById($id);

        if ($recommendation->getSource()->getId() !== $this->app['user']->getId()) {
            throw new InvalidArgumentException('You can not delete recommendations from others');
        }
    }
}
