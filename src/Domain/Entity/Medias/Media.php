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
interface Media extends Entity
{
    /**
     * @return string
     */
    public function getPublicId();

    /**
     * @param string $publicId
     */
    public function setPublicId($publicId);

    /**
     * @return string
     */
    public function getEtag();

    /**
     * @param string $etag
     */
    public function setEtag($etag);

    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param mixed $type
     */
    public function setType($type);

    /**
     * @return User
     */
    public function getUser();

    /**
     * @param User $user
     */
    public function setUser(User $user);
}
