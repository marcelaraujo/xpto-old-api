<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Signup;

use Xpto\Service\Users\Profile as ProfileService;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Signup Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Signup extends ServiceProviderInterface
{
    /**
     * @param Request $request
     * @param ProfileService $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function create(Request $request, ProfileService $profileService);
}
