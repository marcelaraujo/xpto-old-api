<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Signup;

use Domain\Service\Signup\Signup as SignupServiceInterface;
use Xpto\Service\Users\Profile as ProfileService;
use Xpto\Factory\Users\Profile as ProfileFactory;
use Xpto\Factory\Users\User as UserFactory;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Signup implements SignupServiceInterface
{
    /**
     * @const string
     */
    const SIGNUP_SIGNUP = 'signup.signup';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::SIGNUP_SIGNUP] = $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param Request $request
     * @param ProfileService $profileService
     * @return \Xpto\Entity\Users\Profile
     */
    public function create(Request $request, ProfileService $profileService)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $profile = ProfileFactory::create($request);

        $profileService->save($profile);

        return $profile;
    }
}
