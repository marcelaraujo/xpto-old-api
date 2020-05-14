<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Login;

use DateTime;
use Domain\Entity\Entity;
use Domain\Entity\Users\User;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Token extends Entity
{
    /**
     * Get the User
     *
     * @return User
     */
    public function getUser();

    /**
     * Set the User
     *
     * @param  User $user
     * @return void
     */
    public function setUser(User $user);

    /**
     * Get the expiration date
     *
     * @return DateTime
     */
    public function getExpiration();

    /**
     * @param DateTime $expiration
     * @return void
     */
    public function setExpiration(DateTime $expiration);
}
