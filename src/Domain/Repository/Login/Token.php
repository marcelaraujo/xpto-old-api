<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Login;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Token extends Repository
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findAllByUser(User $user);
}
