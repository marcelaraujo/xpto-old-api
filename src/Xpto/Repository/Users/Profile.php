<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Users;

use Domain\Repository\Users\Profile as ProfileRepositoryInterface;
use Xpto\Entity\Users\Profile as ProfileModel;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Profile extends Repository implements ProfileRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\Profile')->findBy(
            [
                'status' => [
                    ProfileModel::ACTIVE,
                    ProfileModel::NEWER,
                ]
            ]
        );

        return $profiles;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $profile = $this->em->getRepository('Xpto\Entity\Users\Profile')->findOneBy(
            [
                'id' => $id,
                'status' => [
                    ProfileModel::ACTIVE,
                    ProfileModel::NEWER,
                ]
            ]
        );

        if (null === $profile || $profile->isDeleted()) {
            throw new OutOfRangeException('Profile not found', 404);
        }

        return $profile;
    }

    /**
     * @see \Domain\Repository\Users\Profile::findByNickame()
     */
    public function findByNickname($nickname)
    {
        $profile = $this->em->getRepository('\Xpto\Entity\Users\Profile')->findOneBy(
            [
                'nickname' => $nickname,
                'status' => [
                    ProfileModel::ACTIVE,
                    ProfileModel::NEWER,
                ]
            ]
        );

        if (null === $profile || $profile->isDeleted()) {
            throw new OutOfRangeException(sprintf('Profile %s is not found', $nickname), 404);
        }

        return $profile;
    }

    /**
     * @see \Domain\Repository\Users\Profile::findByUserName()
     */
    public function findByUserName($name)
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\User')
            ->createQueryBuilder('u')
            ->where('u.name = :name')
            ->setParameter('name', "%{$name}%")
            ->getQuery()
            ->getResult();

        return $profiles;
    }

    /**
     * @see \Domain\Repository\Users\Profile::findByBio()
     */
    public function findByBio($bio)
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\Profile')
            ->createQueryBuilder('p')
            ->where('p.bioRelease LIKE :bio')
            ->orWhere('p.fullRelease LIKE :bio')
            ->setParameter('bio', "%{$bio}%")
            ->getQuery()
            ->getResult();

        return $profiles;
    }

    /**
     * @see \Domain\Repository\Users\Profile::findByLocation()
     */
    public function findByLocation($location)
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\Profile')
            ->createQueryBuilder('p')
            ->where('p.locationLive LIKE :location')
            ->orWhere('p.locationBorn LIKE :location')
            ->setParameter('location', "%{$location}%")
            ->getQuery()
            ->getResult();

        return $profiles;
    }

    /**
     * @see \Domain\Repository\Users\User::findUser()
     */
    public function findByUser($user)
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\Profile')
            ->findOneByUser($user);

        return $profiles;
    }

    /**
     * Find all newer users
     *
     * @param  int $area
     * @return UserModel[]
     */
    public function findNewerByWorkArea($area)
    {
        $profiles = $this->em->getRepository('Xpto\Entity\Users\Profile')->findBy(
            [
                'workArea' => $area,
                'status' => ProfileModel::NEWER
            ]
        );

        return $profiles;
    }
}
