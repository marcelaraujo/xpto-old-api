<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Medias;

use Domain\Entity\Users\User as UserModel;
use Domain\Repository\Medias\Album as AlbumRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * The Albums Repository
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Album extends Repository implements AlbumRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $albums = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findAll();

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $album = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findOneById($id);

        if (null === $album || $album->isDeleted()) {
            throw new OutOfRangeException('Album not found', 404);
        }

        $medias = $album->getMedias();

        $album->setMedias($medias);

        return $album;
    }

    /**
     * @param integer $type
     * @return Album[]
     */
    public function findByType($type)
    {
        $albums = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findByType($type);

        return $albums;
    }

    /**
     * @param UserModel $user
     * @param integer $type
     * @return Album[]
     */
    public function findOneByUserAndType(UserModel $user, $type)
    {
        $albums = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findOneBy(
            [
                'user' => $user,
                'type' => $type
            ]
        );

        return $albums;
    }

    /**
     * @param UserModel $user
     * @param integer $type
     * @return Album[]
     */
    public function findByUserAndType(UserModel $user, $type)
    {
        $albums = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findBy(
            [
                'user' => $user,
                'type' => $type
            ]
        );

        return $albums;
    }

    /**
     * @param UserModel $user
     * @return Album[]
     */
    public function findByUser(UserModel $user)
    {
        $albums = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findBy(
            [
                'user' => $user,
            ]
        );

        return $albums;
    }

    /**
     * @see \Xpto\Repository\Repository::findOneByIdAndUser()
     */
    public function findOneByIdAndUser($id, UserModel $user)
    {
        $album = $this->em->getRepository('\Xpto\Entity\Medias\Album')->findOneBy(
            [
                'id' => $id,
                'user' => $user
            ]
        );

        if (null === $album || $album->isDeleted()) {
            throw new OutOfRangeException('Album not found', 404);
        }

        $medias = $album->getMedias();

        $album->setMedias($medias);

        return $album;
    }
}
