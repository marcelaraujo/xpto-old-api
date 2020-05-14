<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Medias\Media;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Like
{
    /**
     * Get likes from a media publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request);

    /**
     * Like a media publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * Removes like from a publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);
}
