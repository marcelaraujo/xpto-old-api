<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Inbox;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Inbox extends Repository
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findAllByUser(User $user);

    /**
     * @param int $id
     * @param User $user
     * @return mixed
     */
    public function findOneByIdAndUser($id, User $user);

    /**
     * @param UserModel $user
     * @return mixed
     */
    public function findAllWithUser(User $user);
}
