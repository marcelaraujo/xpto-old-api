<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Search;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Search
{
    /**
     * GET Request for /search/name/{name}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function name(Application $app, Request $request);

    /**
     * GET Request for /search/bio/{bio}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function bio(Application $app, Request $request);

    /**
     * GET Request for /search/location/{location}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function location(Application $app, Request $request);
}
