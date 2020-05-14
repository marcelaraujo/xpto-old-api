<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Trusteeship;

use Domain\Controller\Trusteeship\Trusteeship as TrusteeshipControllerInterface;
use Xpto\Application;
use Xpto\Service\Users\Profile as ProfileService;
use Xpto\View\Json as View;
use Domain\Value\UserType;
use Xpto\Service\Trusteeship\Trusteeship as TrusteeshipService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Trusteeship Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Trusteeship implements TrusteeshipControllerInterface
{
    /**
     * Router only to Curator user
     *
     * @param Application $app
     * @param Request $request
     * @return void
     */
    private function preAll(Application $app, Request $request)
    {
        if ($app['user']->getType() !== UserType::CURATOR) {
            throw new AccessDeniedHttpException('This router is only to curators');
        }
    }

    /**
     * GET Request for /
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $this->preAll($app, $request);

        $users = $app[TrusteeshipService::TRUSTEESHIP_TRUSTEESHIP]->listAll(
            $app['user'],
            $app[ProfileService::USER_PROFILE]
        );

        return new View($users, View::HTTP_OK);
    }

    /**
     * PUT request route for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request)
    {
        $this->preAll($app, $request);

        $app['dispatcher']->dispatch('trusteeship.pre-approve');

        $app['profile'] = $app[TrusteeshipService::TRUSTEESHIP_TRUSTEESHIP]->approve(
            $request->get('id'),
            $app['user'],
            $app[ProfileService::USER_PROFILE]
        );

        $app['dispatcher']->dispatch('trusteeship.approve');

        return new View($app['profile'], View::HTTP_NO_CONTENT);
    }

    /**
     * Decline access to a creative
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request)
    {
        $this->preAll($app, $request);

        $app['dispatcher']->dispatch('trusteeship.pre-decline');

        $app['profile'] = $app[TrusteeshipService::TRUSTEESHIP_TRUSTEESHIP]->decline(
            $request->get('id'),
            $app['user'],
            $app[ProfileService::USER_PROFILE]
        );

        $app['dispatcher']->dispatch('trusteeship.decline');

        return new View($app['profile'], View::HTTP_NO_CONTENT);
    }
}
