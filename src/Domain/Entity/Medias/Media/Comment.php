<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Medias\Media;

use Domain\Entity\Entity;
use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Users\User as UserInterface;

/**
 * Comment entity interface
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Comment extends Entity
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
     * @return MediaInterface
     */
    public function getMedia();

    /**
     * @param MediaInterface $media
     */
    public function setMedia(MediaInterface $media);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $comment
     */
    public function setContent($comment);
}
