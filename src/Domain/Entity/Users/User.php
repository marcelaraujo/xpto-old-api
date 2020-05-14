<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Users;

use Domain\Entity\Entity;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface User extends Entity
{
    /**
     * Reproved user
     *
     * @var int
     */
    const REPROVED = 4;

    /**
     * Set Name
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setName($Name = '');

    /**
     * Get the Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set the email
     *
     * @param string $email
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setEmail($email);

    /**
     * Get the password
     *
     * @return string
     */
    public function getPassword();

    /**
     * Get the user type
     *
     * @return int
     */
    public function getType();

    /**
     * Set the user type
     *
     * @param int $type
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setType($type);
}
