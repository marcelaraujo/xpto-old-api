<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Login;

use Xpto\Entity\Login\Token as TokenModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Token extends Repository
{
    /**
     * Find all from user
     *
     * @param  UserModel $user
     * @return TokenModel[]
     */
    public function findAllByUser(UserModel $user)
    {
        $tokens = $this->em->getRepository('Xpto\Entity\Login\Token')->findBy(
            [
                'user' => $user,
                'status' => [
                    TokenModel::ACTIVE,
                    TokenModel::NEWER
                ]
            ]
        );

        return $tokens;
    }

    /**
     * Find all
     *
     * @return TokenModel[]
     */
    public function findAll()
    {
        $tokens = $this->em->getRepository('Xpto\Entity\Login\Token')->findBy(
            [
                'status' => [
                    TokenModel::ACTIVE,
                    TokenModel::NEWER
                ]
            ]
        );

        return $tokens;
    }

    /**
     * Find One
     *
     * @param integer $id
     *
     * @return TokenModel
     */
    public function findById($id)
    {
        $tokens = $this->em->getRepository('Xpto\Entity\Login\Token')->findOneBy(
            [
                'id' => $id,
                'status' => [
                    TokenModel::ACTIVE,
                    TokenModel::NEWER
                ]
            ]
        );

        return $tokens;
    }
}
