<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Users;

use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface User extends Repository
{
    /**
     * Find user by token
     *
     * @param string $token
     */
    public function findByToken($token);
}
