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
 * Logout Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Logout
{
    /**
     * Delete all active sessions
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);
}
