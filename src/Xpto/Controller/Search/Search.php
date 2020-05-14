<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Search;

use Domain\Controller\Search\Search as SearchControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Search\Profile as ProfileSearchService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Search implements SearchControllerInterface
{
    /**
     * GET Request for /search/name/{name}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function name(Application $app, Request $request)
    {
        $profiles = $app[ProfileSearchService::SEARCH_BY_NAME]($request->get('name'));

        return new View($profiles);
    }
    /**
     * GET Request for /search/bio/{bio}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function bio(Application $app, Request $request)
    {
        $profiles = $app[ProfileSearchService::SEARCH_BY_BIO]($request->get('bio'));

        return new View($profiles);
    }
    /**
     * GET Request for /search/location/{location}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function location(Application $app, Request $request)
    {
        $profiles = $app[ProfileSearchService::SEARCH_BY_LOCATION]($request->get('location'));

        return new View($profiles);
    }
}
