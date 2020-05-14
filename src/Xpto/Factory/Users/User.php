<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Users;

use Common\Password;
use Xpto\Entity\Users\User as UserModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * The User Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class User
{
    /**
     *
     * @param Request $user
     * @return UserModel
     */
    public static function create(Request $user)
    {
        $password = Password::generate($user->get('password'));

        $obj = new UserModel();
        $obj->setName($user->get('name'));
        $obj->setEmail($user->get('email'));
        $obj->setPassword($password);
        $obj->setStatus(UserModel::ACTIVE);

        return $obj;
    }

    /**
     *
     * @param UserModel $user
     * @param Request $req
     * @return UserModel
     */
    public static function update(UserModel $user, Request $req)
    {
        $user->setName($req->get('name'));
        $user->setEmail($req->get('email'));

        return $user;
    }
}
