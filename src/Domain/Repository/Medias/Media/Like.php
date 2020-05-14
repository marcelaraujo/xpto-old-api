<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Medias\Media;

use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Repository as RepositoryInterface;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Like extends RepositoryInterface
{
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function findByUser(UserInterface $user);

    /**
     * @param MediaInterface $media
     * @return mixed
     */
    public function findByMedia(MediaInterface $media);

    /**
     * @param MediaInterface $media
     * @param UserInterface $user
     * @return mixed
     */
    public function findByMediaAndUser(MediaInterface $media, UserInterface $user);
}
