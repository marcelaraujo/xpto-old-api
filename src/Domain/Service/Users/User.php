<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Users;

use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;

/**
 * User Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface User extends ServiceProviderInterface
{
    /**
     * @param  \Domain\Entity\Users\User $user
     * @return \Domain\Entity\Users\User
     */
    public function save(UserModel $user);

    /**
     * @param  UserModel $user
     * @return boolean
     */
    public function delete(UserModel $user);
}
