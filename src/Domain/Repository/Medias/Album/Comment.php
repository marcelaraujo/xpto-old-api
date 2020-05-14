<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Medias\Album;

use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Repository as RepositoryInterface;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Comment extends RepositoryInterface
{
    /**
     * @param AlbumInterface $album
     * @return mixed
     */
    public function findByAlbum(AlbumInterface $album);

    /**
     * @param AlbumInterface $album
     * @param UserInterface $user
     * @return mixed
     */
    public function findByAlbumAndUser(AlbumInterface $album, UserInterface $user);
}
