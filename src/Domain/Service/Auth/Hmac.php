<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Auth;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hmac Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.com>
 */
interface Hmac extends ServiceProviderInterface
{
    /**
     * @param Application $application
     * @param Request $request
     * @param string $token
     * @return bool
     */
    public function validate(Application $application, Request $request, $token = '');
}
