<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Index Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Index
{
    /**
     * Index Controller
     *
     * @param  Application $app
     * @param  Request $request
     * @return Application
     */
    public function get(Application $app, Request $request);
}
