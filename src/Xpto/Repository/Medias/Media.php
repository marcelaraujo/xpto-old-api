<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias;

use Domain\Entity\Users\User as UserModel;
use Domain\Repository\Medias\Media as MediaRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Media extends Repository implements MediaRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        return $this->em->getRepository('Xpto\Entity\Medias\Media')->findAll();
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $media = $this->em->getRepository('Xpto\Entity\Medias\Media')->findOneById($id);

        if (null === $media || $media->isDeleted()) {
            throw new OutOfRangeException('Media not found', 404);
        }

        return $media;
    }

    /**
     * @see \Domain\Repository\Medias\Media::findByUser()
     */
    public function findByUser(UserModel $user)
    {
        $media = $this->em->getRepository('Xpto\Entity\Medias\Media')->findByUser($user);

        return $media;
    }

    /**
     * @see \Xpto\Repository\Repository::findOneByIdAndUser()
     */
    public function findOneByIdAndUser($id, UserModel $user)
    {
        $media = $this->em->getRepository('Xpto\Entity\Medias\Media')->findOneBy(
            [
                'id' => $id,
                'user' => $user
            ]
        );

        if (null === $media || $media->isDeleted()) {
            throw new OutOfRangeException('Media not found', 404);
        }

        return $media;
    }
}
