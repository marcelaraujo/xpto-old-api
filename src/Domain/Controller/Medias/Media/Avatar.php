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
 * Avatar Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Avatar
{
    /**
     * Create an avatar media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);
}
