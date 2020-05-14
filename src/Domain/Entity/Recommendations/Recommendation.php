<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Recommendations;

use Domain\Entity\Entity as EntityInterface;
use Domain\Entity\Users\User;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Recommendation extends EntityInterface
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
     * @param User $source
     *
     * @return void
     */
    public function setSource(User $source);

    /**
     * @return User
     */
    public function getSource();

    /**
     *
     * @param User $destination
     *
     * @return void
     */
    public function setDestination(User $destination);

    /**
     * @return User
     */
    public function getDestination();

    /**
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMessage();
}
