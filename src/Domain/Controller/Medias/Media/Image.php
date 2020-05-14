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
 * Image Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Image
{
    /**
     * Create an image media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     * @throws UploadException
     */
    public function post(Application $app, Request $request);
}
