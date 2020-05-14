<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias\Media;

use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Medias\Media\Comment as CommentInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Medias\Media\Comment as CommentRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment extends Repository implements CommentRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')->findAll();

        return $medias;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $media = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')
            ->findOneById($id);

        if (null === $media || $media->isDeleted()) {
            throw new OutOfRangeException('Media not found', 404);
        }

        return $media;
    }

    /**
     * @see \Xpto\Repository\Medias\Comment::findByUser()
     */
    public function findByUser(UserInterface $user)
    {
        $media = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')
            ->findByUser($user);

        return $media;
    }

    /**
     * @see \Xpto\Repository\Medias\Comment::findByMedia()
     */
    public function findByMedia(MediaInterface $media)
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')
            ->findBy(
                [
                    'media' => $media
                ]
            );

        return $medias;
    }

    /**
     * @see \Xpto\Repository\Medias\Comment::findByMediaAndUser()
     */
    public function findByMediaAndUser(MediaInterface $media, UserInterface $user)
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')
            ->findOneBy(
                [
                    'media' => $media,
                    'user' => $user,
                ]
            );

        return $medias;
    }

    /**
     * @see \Xpto\Repository\Medias\Comment::findByCommentAndUser()
     */
    public function findByCommentAndUser(CommentInterface $comment, UserInterface $user)
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Comment')
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
