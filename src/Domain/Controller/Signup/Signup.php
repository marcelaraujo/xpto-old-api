<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Signup;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Signup Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Signup
{
    /**
     * Create an user
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function create(Application $app, Request $request);
}
