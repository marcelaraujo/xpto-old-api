<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Recommendations;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Recommendation
{
    /**
     * GET request for /recommendation/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /recommendation/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request);

    /**
     * POST request for /recommendation/{id}
     *
     * When {id} is a destination user to recommence
     *
     * @param Application $app
     * @param Request $request
     * @return View
     */
    public function create(Application $app, Request $request);

    /**
     * Approve request for /approve/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request);

    /**
     * Decline connection request for /decline/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request);

    /**
     * Update a recommendation
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request);

    /**
     * DELETE request route for /recommendation/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);
}
