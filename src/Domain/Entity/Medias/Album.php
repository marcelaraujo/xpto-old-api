<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Medias;

use Domain\Entity\Entity;
use Domain\Entity\Users\User;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Album extends Entity
{
    /**
     * Set Title
     *
     * @return void
     */
    public function setTitle($title = '');

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set if the album show in profile
     *
     * @param boolean $cover
     */
    public function setCover($cover);

    /**
     * Get the cover
     *
     * @return int
     */
    public function getCover();

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
     *
     */
    public function isCover();
}
