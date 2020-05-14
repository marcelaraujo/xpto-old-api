<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias\Album;

use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Medias\Album\Like as LikeRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * Album like repository
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like extends Repository implements LikeRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Like')->findAll();

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $album = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Like')
            ->findOneById($id);

        if (null === $album || $album->isDeleted()) {
            throw new OutOfRangeException('Album not found', 404);
        }

        return $album;
    }

    /**
     * @see \Xpto\Repository\Albums\Like::findByUser()
     */
    public function findByUser(UserInterface $user)
    {
        $album = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Like')
            ->findByUser($user);

        return $album;
    }

    /**
     * @see \Xpto\Repository\Albums\Like::findByAlbum()
     */
    public function findByAlbum(AlbumInterface $album)
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Like')
            ->findBy(
                [
                    'album' => $album
                ]
            );

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Albums\Like::findByAlbumAndUser()
     */
    public function findByAlbumAndUser(AlbumInterface $album, UserInterface $user)
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Like')
            ->findOneBy(
                [
                    'album' => $album,
                    'user' => $user,
                ]
            );

        return $albums;
    }
}
