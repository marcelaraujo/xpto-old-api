<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Recommendations;

use Domain\Entity\Users\User as UserModel;
use Domain\Entity\Recommendations\Recommendation as RecommendationModel;
use Domain\Service\Connections\Connection as ConnectionService;
use Domain\Service\Users\User as UserServiceInterface;
use Domain\Service\Recommendations\Recommendation as RecommendationServiceInterface;
use Xpto\Factory\Recommendations\Recommendation as RecommendationFactory;
use Xpto\Repository\Recommendations\Recommendation as RecommendationRepository;
use Xpto\Repository\Users\Profile as ProfileRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Recommendation implements RecommendationServiceInterface
{
    /**
     * @const string
     */
    const RECOMMENDATION = 'recommendation';
    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::RECOMMENDATION] = $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param  RecommendationModel $recommendation
     * @return RecommendationModel
     */
    public function save(RecommendationModel $recommendation, ConnectionService $connection)
    {
        if (!$connection->checkConnectivity($recommendation->getSource(), $recommendation->getDestination())) {
            $error = 'The user destination is not on connection list or no approved connection request';

            throw new InvalidArgumentException($error, 500);
        }

        $this->em->persist($recommendation);
        $this->em->flush();

        return $recommendation;
    }

    /**
     * @param  RecommendationModel $recommendation
     * @return boolean
     */
    public function delete(RecommendationModel $recommendation)
    {
        if ($recommendation->isDeleted()) {
            throw new InvalidArgumentException('This recommendation is already deleted.');
        }

        $recommendation->setStatus(RecommendationModel::DELETED);

        $this->em->persist($recommendation);
        $this->em->flush();

        return true;
    }

    /**
     * @param UserModel $user
     * @return \Xpto\Entity\Recommendations\Recommendation[]
     */
    public function listByUser(UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Recommendations\Recommendation */
        $repo = new RecommendationRepository($this->em);

        /* @var $recommendations \Xpto\Entity\Recommendations\Recommendation[] */
        $recommendations = $repo->findPendingAndApprovedFromUser($user);

        return $recommendations;
    }

    /**
     * @param int $id
     * @param UserModel $user
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function view($id, UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Recommendations\Recommendation */
        $repo = new RecommendationRepository($this->em);

        /* @var $recommendation \Xpto\Entity\Recommendations\Recommendation */
        $recommendation = $repo->findOneByIdAndUser($id, $user);

        return $recommendation;
    }

    /**
     * @param UserModel $recommender
     * @param UserModel $recommended
     * @param Request $request
     * @param ConnectionService $connection
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function recommend(
        UserModel $recommender,
        UserModel $recommended,
        Request $request,
        ConnectionService $connection
    ) {
        $request->attributes->set('source', $recommender->getId());
        $request->attributes->set('destination', $recommended->getId());

        /* @var $recommendation \Xpto\Entity\Recommendations\Recommendation */
        $recommendation = RecommendationFactory::create($request, $this->em);

        $this->save($recommendation, $connection);

        return $recommendation;
    }

    /**
     * @param int $id
     * @param UserModel $recommended
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function approve($id, UserModel $recommended)
    {
        $recommendation = $this->view($id, $recommended);

        if ($recommended->getId() !== $recommendation->getDestination()->getId()) {
            throw new InvalidArgumentException('You do not approve recommendations to others users');
        }

        $recommendation->setStatus(RecommendationModel::APPROVED);

        $this->em->persist($recommendation);
        $this->em->flush();

        return $recommendation;
    }

    /**
     * @param int $id
     * @param UserModel $recommended
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function reprove($id, UserModel $recommended)
    {
        $recommendation = $this->view($id, $recommended);

        if ($recommended->getId() !== $recommendation->getDestination()->getId()) {
            throw new InvalidArgumentException('You do not reprove recommendations to others users');
        }

        $recommendation->setStatus(RecommendationModel::REPPROVED);

        $this->em->persist($recommendation);
        $this->em->flush();

        return $recommendation;
    }

    /**
     * @param int $id
     * @param UserModel $recommender
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function remove($id, UserModel $recommender)
    {
        $recommendation = $this->view($id, $recommender);

        if ($recommender->getId() !== $recommendation->getSource()->getId()) {
            throw new InvalidArgumentException('You do not remove recommendations to others users');
        }

        $this->delete($recommendation);

        return $recommendation;
    }

    /**
     * @param int $id
     * @param UserModel $recommender
     * @param Request $request
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function update($id, UserModel $recommender, Request $request)
    {
        $recommendation = $this->view($id, $recommender);

        $result = RecommendationFactory::update($recommendation, $request);

        $this->em->persist($result);
        $this->em->flush();

        return $result;
    }

    /**
     * List approved connections from an user
     *
     * @param string $nickname
     * @param UserServiceInterface $userService
     * @return \Xpto\Entity\Recommendations\Recommendation[]
     */
    public function listApprovedByNickname($nickname, UserServiceInterface $userService)
    {
        $user = $userService->findByNickname($nickname);

        /* @var $repositoryConnection \Xpto\Repository\Recommendations\Recommendation */
        $repositoryConnection = new RecommendationRepository($this->em);

        /* @var $recommendations \Xpto\Entity\\Recommendations\Recommendation[] */
        $recommendations = $repositoryConnection->findApprovedFromUser($user);

        return $recommendations;
    }

    /**
     * List approved connections from an user id
     *
     * @param int $userId
     * @param UserServiceInterface $userService
     * @return \Xpto\Entity\Recommendations\Recommendation[]
     */
    public function listApprovedByUserId($userId, UserServiceInterface $userService)
    {
        $user = $userService->findByUserId($userId);

        /* @var $repositoryConnection \Xpto\Repository\Recommendations\Recommendation */
        $repositoryConnection = new RecommendationRepository($this->em);

        /* @var $recommendations \Xpto\Entity\\Recommendations\Recommendation[] */
        $recommendations = $repositoryConnection->findApprovedFromUser($user);

        return $recommendations;
    }
}
