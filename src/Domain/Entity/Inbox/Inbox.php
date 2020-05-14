<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Inbox;

use Domain\Entity\Entity;
use Domain\Entity\Users\User;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Inbox extends Entity
{
    /**
     * Read by destination user
     *
     * @var int
     */
    const READ_BY_DESTINATION = 4;

    /**
     * Archived message
     *
     * @var int
     */
    const ARCHIVED = 5;

    /**
     * @return User
     */
    public function getSource();

    /**
     *
     * @param User $source
     *
     * @return void
     */
    public function setSource(User $source);

    /**
     * @return User
     */
    public function getDestination();

    /**
     *
     * @param User $destination
     *
     * @return void
     */
    public function setDestination(User $destination);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     */
    public function setBody($body);

    /**
     * @return int
     */
    public function getStatusSource();

    /**
     * @param int $status
     */
    public function setStatusSource($status);

    /**
     * @return int
     */
    public function getStatusDestination();

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatusDestination($status);
}
