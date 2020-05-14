<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Auth;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Login Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Login
{
    /**
     * Login action
     * @param Application $app
     * @param Request $request
     * @return View
     */
    public function post(Application $app, Request $request);
}
