<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Connections;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Connection extends Repository
{
    /**
     * @return ConnectionModel[]
     */
    public function findApproved();

    /**
     * @return ConnectionModel[]
     */
    public function findPendingAndApproved();

    /**
     * @param User $user
     * @return ConnectionModel[]
     */
    public function findPendingAndApprovedFromUser(User $user);

    /**
     * @param User $user
     * @return ConnectionModel[]
     */
    public function findApprovedFromUser(User $user);

    /**
     * @param int $id
     * @param User $user
     * @return mixed
     */
    public function findOneByIdAndUser($id, User $user);
}
