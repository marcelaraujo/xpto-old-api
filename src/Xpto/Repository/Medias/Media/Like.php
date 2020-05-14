<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias\Media;

use Domain\Entity\Medias\Media as MediaInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Repository\Medias\Media\Like as LikeRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like extends Repository implements LikeRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Like')->findAll();

        return $medias;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $media = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Like')
            ->findOneById($id);

        if (null === $media || $media->isDeleted()) {
            throw new OutOfRangeException('Media not found', 404);
        }

        return $media;
    }

    /**
     * @see \Xpto\Repository\Medias\Like::findByUser()
     */
    public function findByUser(UserInterface $user)
    {
        $media = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Like')
            ->findByUser($user);

        return $media;
    }

    /**
     * @see \Xpto\Repository\Medias\Like::findByMedia()
     */
    public function findByMedia(MediaInterface $media)
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Like')
            ->findBy(
                [
                    'media' => $media
                ]
            );

        return $medias;
    }

    /**
     * @see \Xpto\Repository\Medias\Like::findByMediaAndUser()
     */
    public function findByMediaAndUser(MediaInterface $media, UserInterface $user)
    {
        $medias = $this->em
            ->getRepository('Xpto\Entity\Medias\Media\Like')
            ->findOneBy(
                [
                    'media' => $media,
                    'user' => $user,
                ]
            );

        return $medias;
    }
}
