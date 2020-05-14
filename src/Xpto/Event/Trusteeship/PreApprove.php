<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Event\Trusteeship;

use Xpto\Repository\Users\Profile as ProfileRepository;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * User event
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
final class PreApprove
{
    /**
     * @var string
     */
    const NAME = 'trusteeship.pre-approve';

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

        $app = $this->app;

        $id = $app['request']->attributes->get('id');

        /* @var $user \Xpto\Entity\Users\User */
        $user = $app['user'];

        /* @var $repository \Xpto\Repository\Users\Profile */
        $repository = new ProfileRepository($app['orm.em']);

        /* @var $profile \Xpto\Entity\Users\Profile */
        $profile = $repository->findById($id);

        /* @var $curatorProfile \Xpto\Entity\Users\Profile */
        $curatorProfile = $repository->findByUser($app['user']);

        if ($curatorProfile->getWorkArea() !== $profile->getWorkArea()) {
            throw new AccessDeniedHttpException('You can only approve users from your work area');
        }
    }
}
