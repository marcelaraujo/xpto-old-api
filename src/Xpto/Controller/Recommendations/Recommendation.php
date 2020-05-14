<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Recommendations;

use Domain\Controller\Recommendations\Recommendation as RecommendationControllerInterface;
use Xpto\Application;
use Xpto\Service\Connections\Connection;
use Xpto\Service\Recommendations\Recommendation as RecommendationService;
use Xpto\Service\Users\User;
use Xpto\View\Json as View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Recommendation implements RecommendationControllerInterface
{
    /**
     * GET request for /recommendation/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app)
    {
        $recommendations = $app[RecommendationService::RECOMMENDATION]->listByUser($app['user']);

        return new View($recommendations, View::HTTP_OK);
    }

    /**
     * GET request for /recommendation/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $recommendation = $app[RecommendationService::RECOMMENDATION]->view($request->get('id'), $app['user']);

        return new View($recommendation, View::HTTP_OK);
    }

    /**
     * POST request for /recommendation/{id}
     *
     * When {id} is a destination user to recommence
     *
     * @param Application $app
     * @param Request $request
     * @return View
     */
    public function create(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('recommendation.pre-create');

        $app['recommendation'] = $app[RecommendationService::RECOMMENDATION]->recommend(
            $app['user'],
            $app[User::USER_USER]->findByUserId($request->get('id')),
            $request,
            $app[Connection::CONNECTION]
        );

        $app['dispatcher']->dispatch('recommendation.create');

        return new View($app['recommendation'], View::HTTP_CREATED);
    }

    /**
     * Approve request for /approve/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('recommendation.pre-approve');

        $app['recommendation'] = $app[RecommendationService::RECOMMENDATION]->approve(
            $request->get('id'),
            $app['user']
        );

        $app['dispatcher']->dispatch('recommendation.approve');

        return new View($app['recommendation'], View::HTTP_NO_CONTENT);
    }

    /**
     * Decline connection request for /decline/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('recommendation.pre-decline');

        $app['recommendation'] = $app[RecommendationService::RECOMMENDATION]->reprove(
            $request->get('id'),
            $app['user']
        );

        $app['dispatcher']->dispatch('recommendation.decline');

        return new View($app['recommendation'], View::HTTP_NO_CONTENT);
    }

    /**
     * Update a recommendation
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('recommendation.pre-update');

        $app['recommendation'] = $app[RecommendationService::RECOMMENDATION]->update(
            $request->get('id'),
            $app['user'],
            $request
        );

        $app['dispatcher']->dispatch('recommendation.update');

        return new View($app['recommendation'], View::HTTP_NO_CONTENT);
    }

    /**
     * DELETE request route for /recommendation/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('recommendation.pre-delete');

        $app['recommendation'] = $app[RecommendationService::RECOMMENDATION]->remove(
            $request->get('id'),
            $app['user']
        );

        $app['dispatcher']->dispatch('recommendation.delete');

        return new View($app['recommendation'], View::HTTP_NO_CONTENT);
    }

    /**
     * GET request for /connection/{id}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByUserId(Application $app, Request $request)
    {
        $connections = $app[RecommendationService::RECOMMENDATION]->listApprovedByUserId($request->get('id'), $app['user.user']);

        return new View($connections, View::HTTP_OK);
    }

    /**
     * GET request for /connection/{nickname}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByNickname(Application $app, Request $request)
    {
        $connections = $app[RecommendationService::RECOMMENDATION]->listApprovedByNickname($request->get('nickname'), $app['user.user']);

        return new View($connections, View::HTTP_OK);
    }
}
