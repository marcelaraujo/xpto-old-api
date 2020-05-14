<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Notifications;

use Domain\Entity\Users\User as UserModel;
use Domain\Entity\Notifications\Notification as NotificationModel;
use Domain\Service\Notifications\Notification as NotificationServiceInterface;
use Xpto\Repository\Notifications\Notification as NotificationRepository;
use InvalidArgumentException;
use Silex\Application;

/**
 * Notification Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Notification implements NotificationServiceInterface
{
    /**
     * @const string
     */
    const NOTIFICATION = 'notification';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $service = $this;

        $this->em = $app['orm.em'];

        $app[self::NOTIFICATION] = $service;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param  NotificationModel $notification
     * @return NotificationModel
     */
    public function save(NotificationModel $notification)
    {
        $this->em->persist($notification);
        $this->em->flush();

        return $notification;
    }

    /**
     * @param  NotificationModel $notification
     * @return boolean
     */
    public function delete(NotificationModel $notification)
    {
        if ($notification->isDeleted()) {
            throw new InvalidArgumentException('This notification is already deleted.');
        }

        $notification->setStatus(NotificationModel::DELETED);

        $this->save($notification);

        return true;
    }

    /**
     * @param NotificationModel $notification
     * @return boolean
     */
    public function markAsRead(NotificationModel $notification)
    {
        $notification->setStatus(NotificationModel::READ);

        $this->save($notification);

        return true;
    }

    /**
     * @param UserModel $user
     * @return \Xpto\Entity\Notifications\Notification[]
     */
    public function listByUser(UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Notifications\Notification */
        $repo = new NotificationRepository($this->em);

        /* @var $notifications \Xpto\Entity\Notifications\Notification[] */
        $notifications = $repo->findByUser($user);

        return $notifications;
    }

    /**
     * @param int $id
     * @param UserModel $user
     * @return \Xpto\Entity\Notifications\Notification
     */
    public function view($id, UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Notifications\Notification */
        $repo = new NotificationRepository($this->em);

        /* @var $notification \Xpto\Entity\Notifications\Notification */
        $notification = $repo->findOneByIdAndUser($id, $user);

        $this->markAsRead($notification);

        return $notification;
    }
}
