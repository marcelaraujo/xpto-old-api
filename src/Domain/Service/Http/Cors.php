<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Http;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hmac Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.com>
 */
interface Cors extends ServiceProviderInterface
{
    /**
     * @param $app Application
     * @param $request Request
     * @param $response Response
     * @return boolean
     */
    public function handle(Application $app, Request $request, Response $response);
}
