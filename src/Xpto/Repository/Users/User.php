<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Users;

use Domain\Entity\Login\Token as UserToken;
use Domain\Entity\Users\User as UserModel;
use Domain\Repository\Users\User as UserRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class User extends Repository implements UserRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $users = $this->em->getRepository('Xpto\Entity\Users\User')->findAll();

        return $users;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $user = $this->em->getRepository('Xpto\Entity\Users\User')->findOneById($id);

        if (null === $user || $user->isDeleted()) {
            throw new OutOfRangeException('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Find user by token
     *
     * @param  string $token
     * @return UserModel
     */
    public function findByToken($token)
    {
        $user = $this->em->getRepository('Xpto\Entity\Login\Token')->findOneBy(
            [
                'content' => trim($token),
                'status' => UserToken::ACTIVE
            ]
        );

        if (null === $user || $user->isDeleted()) {
            throw new OutOfRangeException('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user->getUser();
    }

    /**
     * Find an user by email
     *
     * @param  string $email
     * @throws OutOfRangeException
     * @return UserModel
     */
    public function findByEmail($email)
    {
        /* @var $user UserModel */
        $user = $this->em->getRepository('Xpto\Entity\Users\User')->findOneBy(
            [
                'email' => $email,
                'status' => UserModel::ACTIVE
            ]
        );

        if (null === $user || $user->isDeleted()) {
            throw new OutOfRangeException('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Find all users by type
     *
     * @param  int $type
     * @throws OutOfRangeException
     * @return UserModel[]
     */
    public function findByType($type)
    {
        /* @var $user UserModel */
        $user = $this->em->getRepository('Xpto\Entity\Users\User')->findBy(
            [
                'type' => $type,
                'status' => UserModel::ACTIVE
            ]
        );

        return $user;
    }
}
