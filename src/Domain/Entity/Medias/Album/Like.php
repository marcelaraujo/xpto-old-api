<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Medias\Album;

use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Entity;
use Domain\Entity\Users\User as UserInterface;

/**
 * Like entity interface
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Like extends Entity
{
    /**
     * return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * @return string
     */
    public function getAddress();

    /**
     * @param string $address
     */
    public function setAddress($address);

    /**
     * @return string
     */
    public function getAgent();

    /**
     * @param string
     */
    public function setAgent($agent);

    /**
     * @return AlbumInterface
     */
    public function getAlbum();

    /**
     * @param AlbumInterface $album
     */
    public function setAlbum(AlbumInterface $album);
}
