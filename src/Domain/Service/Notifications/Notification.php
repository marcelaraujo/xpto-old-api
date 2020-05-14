<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Notifications;

use Domain\Entity\Users\User as UserModel;
use Domain\Entity\Notifications\Notification as NotificationModel;
use Silex\ServiceProviderInterface;

/**
 * Notification Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Notification extends ServiceProviderInterface
{
    /**
     * @param  NotificationModel $notification
     * @return NotificationModel
     */
    public function save(NotificationModel $notification);

    /**
     * @param  NotificationModel $notification
     * @return boolean
     */
    public function delete(NotificationModel $notification);

    /**
     * @param  NotificationModel $notification
     * @return boolean
     */
    public function markAsRead(NotificationModel $notification);

    /**
     * @param UserModel $user
     * @return NotificationModel[]
     */
    public function listByUser(UserModel $user);

    /**
     * @param int $id
     * @param UserModel $user
     * @return NotificationModel
     */
    public function view($id, UserModel $user);
}
