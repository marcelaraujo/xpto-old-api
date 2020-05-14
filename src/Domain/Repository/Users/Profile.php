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
interface Profile extends Repository
{
    /**
     *
     * @param string $name
     */
    public function findByUserName($name);

    /**
     *
     * @param string $nickname
     */
    public function findByNickname($nickname);

    /**
     *
     * @param string $bio
     */
    public function findByBio($bio);

    /**
     *
     * @param string $location
     */
    public function findByLocation($location);
}
