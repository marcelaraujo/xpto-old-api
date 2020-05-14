<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Recommendations;

use Xpto\Entity\Recommendations\Recommendation as RecommendationModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Recommendations\Recommendation as RecommendationService;
use Xpto\Tests\ChangeProtectedAttribute;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Mockery as m;
use PHPUnit_Framework_TestCase;

/**
 * Recommendation service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class RecommendationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateEmMock
     */
    use CreateEmMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Recommendations\Recommendation::setStatus()
     * @covers Xpto\Entity\Recommendations\Recommendation::isDeleted()
     * @covers Xpto\Service\Recommendations\Recommendation::save()
     * @covers Xpto\Entity\Recommendations\Recommendation::getSource()
     * @covers Xpto\Entity\Recommendations\Recommendation::getDestination()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Entity\Connections\Connection::setSource()
     * @covers Xpto\Entity\Connections\Connection::setDestination()
     * @covers Xpto\Entity\Connections\Connection::setStatus()
     * @covers Xpto\Entity\Connections\Connection::isDeleted()
     * @covers Xpto\Service\Connections\Connection::checkConnectivity()
     */
    public function save()
    {
        $connMock = m::mock('Domain\Service\Connections\Connection');
        $connMock
            ->shouldReceive('checkConnectivity')
            ->andReturn(true)
            ->byDefault();

        $connectionService = new RecommendationService();

        $this->modifyAttribute($connectionService, 'em', $this->getDefaultEmMock());

        $connectionModel = new RecommendationModel();

        $this->modifyAttribute($connectionModel, 'source', new UserModel());
        $this->modifyAttribute($connectionModel, 'destination', new UserModel());

        $result = $connectionService->save($connectionModel, $connMock);

        $this->assertSame($connectionModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Recommendations\Recommendation::setStatus()
     * @covers Xpto\Entity\Recommendations\Recommendation::isDeleted()
     * @covers Xpto\Service\Recommendations\Recommendation::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $connectionModel = new RecommendationModel();

        $connectionService = new RecommendationService();

        $this->modifyAttribute($connectionService, 'em', $this->getDefaultEmMock());

        $result = $connectionService->delete($connectionModel);

        $this->assertTrue($result);
    }
}
