<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Auth;

use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;

/**
 * Logout Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Logout extends ServiceProviderInterface
{
    /**
     * Invalidate all tokens from user
     *
     * @param  UserModel $user
     * @return boolean
     */
    public function logout(UserModel $user);
}
