<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Notifications;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Notification extends Repository
{
    /**
     * @return NotificationModel[]
     */
    public function findByUser(User $user);

    /**
     * @param integer $id
     * @param User $user
     * @return NotificationModel[]
     */
    public function findOneByIdAndUser($id, User $user);
}
