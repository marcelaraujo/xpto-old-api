<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias\Album;

use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Medias\Album\Comment as CommentInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Medias\Album\Comment as CommentRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * Album comment repository
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment extends Repository implements CommentRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')->findAll();

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $album = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')
            ->findOneById($id);

        if (null === $album || $album->isDeleted()) {
            throw new OutOfRangeException('Album not found', 404);
        }

        return $album;
    }

    /**
     * @see \Xpto\Repository\Albums\Comment::findByUser()
     */
    public function findByUser(UserInterface $user)
    {
        $album = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')
            ->findByUser($user);

        return $album;
    }

    /**
     * @see \Xpto\Repository\Albums\Comment::findByAlbum()
     */
    public function findByAlbum(AlbumInterface $album)
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')
            ->findBy(
                [
                    'album' => $album
                ]
            );

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Albums\Comment::findByAlbumAndUser()
     */
    public function findByAlbumAndUser(AlbumInterface $album, UserInterface $user)
    {
        $albums = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')
            ->findOneBy(
                [
                    'album' => $album,
                    'user' => $user,
                ]
            );

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Albums\Comment::findByCommentAndUser()
     */
    public function findByCommentAndUser(CommentInterface $comment, UserInterface $user)
    {
        $medias = $this->em
            ->getRepository('\Xpto\Entity\Medias\Album\Comment')
            ->findOneBy(
                [
                    'id' => $comment->getId(),
                    'user' => $user,
                    'status' => [
                        CommentInterface::NEWER,
                        CommentInterface::ACTIVE,
                    ]
                ]
            );

        return $medias;
    }
}
