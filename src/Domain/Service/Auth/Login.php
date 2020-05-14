<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Auth;

use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Login Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Login extends ServiceProviderInterface
{
    /**
     * Auth user
     *
     * @param  string $username
     * @param  string $password
     * @return UserModel
     */
    public function validateCredentials($username, $password);

    /**
     * Validate the token
     *
     * @param  string $token
     * @return boolean
     */
    public function validateToken($token = null);

    /**
     * Get token from split string
     * @param $token
     * @return mixed
     */
    public function getToken($token);

    /**
     *
     * @param UserModel $user
     * @param Request $request
     * @return string
     */
    public function getNewTokenForUser(UserModel $user, Request $request);

    /**
     *
     * @param unknown $token
     * @return unknown
     */
    public function loadUserByToken($token);
}
