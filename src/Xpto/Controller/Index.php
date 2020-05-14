<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller;

use Domain\Controller\Index as IndexControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Index Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Index implements IndexControllerInterface
{
    /**
     * Index Controller
     *
     * @param  Application $app
     * @param  Request $request
     * @return Application
     */
    public function get(Application $app, Request $request)
    {
        return new View('Hello xpto');
    }
}
