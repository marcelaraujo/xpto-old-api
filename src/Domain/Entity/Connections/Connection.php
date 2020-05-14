<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Connections;

use Domain\Entity\Entity;
use Domain\Entity\Users\User;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Connection extends Entity
{
    /**
     * Approved connection
     *
     * @var int
     */
    const APPROVED = 4;

    /**
     * Repproved connection
     *
     * @var int
     */
    const REPPROVED = 5;

    /**
     * Set the user source
     *
     * @param  User $user
     * @return void
     */
    public function setSource(User $user);

    /**
     * Get the user source
     *
     * @return User
     */
    public function getSource();

    /**
     * Set the user destination
     *
     * @param  User $user
     * @return void
     */
    public function setDestination(User $user);

    /**
     * Get the user destination
     *
     * @return User
     */
    public function getDestination();

    /**
     * Check if this connection is aproved or not
     *
     * @return boolean
     */
    public function isApproved();
}
