<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Search;

use Domain\Service\Search\Profile as ProfileServiceInterface;
use Xpto\Repository\Users\Profile as ProfileRepository;
use Silex\Application;

/**
 * Profile Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Profile implements ProfileServiceInterface
{
    /**
     * @const string
     */
    const SEARCH_BY_NAME = 'search.profile.name';

    /**
     * @const string
     */
    const SEARCH_BY_BIO = 'search.profile.bio';

    /**
     * @const string
     */
    const SEARCH_BY_LOCATION = 'search.profile.location';

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
        $service = $this;

        $this->em = $app['orm.em'];

        $app[self::SEARCH_BY_NAME] = $app->protect(
            function($name) use ($service) {
                return $service->findByName($name);
            }
        );

        $app[self::SEARCH_BY_BIO] = $app->protect(
            function($bio) use ($service) {
                return $service->findByBio($bio);
            }
        );

        $app[self::SEARCH_BY_LOCATION] = $app->protect(
            function($location) use ($service) {
                return $service->findByLocation($location);
            }
        );
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
     * @see \Domain\Service\Search\Profile::findByName()
     */
    public function findByName($name)
    {
        $repository = new ProfileRepository($this->em);
        $result = $repository->findByUserName($name);

        return $result;
    }

    /**
     * @see \Domain\Service\Search\Profile::findByBio()
     */
    public function findByBio($bio)
    {
        $repository = new ProfileRepository($this->em);
        $result = $repository->findByBio($bio);

        return $result;
    }

    /**
     * @see \Domain\Service\Search\Profile::findByLocation()
     */
    public function findByLocation($location)
    {
        $repository = new ProfileRepository($this->em);
        $result = $repository->findByLocation($location);

        return $result;
    }
}
