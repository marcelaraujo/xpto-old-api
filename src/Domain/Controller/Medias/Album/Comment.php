<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Medias\Album;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Comment
{
    /**
     * Get comments from a album publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function get(Application $app, Request $request);

    /**
     * Comment a album publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * Removes comment from a publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function delete(Application $app, Request $request);
}
