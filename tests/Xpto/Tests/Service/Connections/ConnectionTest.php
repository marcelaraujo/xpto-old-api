<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Connections;

use Xpto\Entity\Connections\Connection as ConnectionModel;
use Xpto\Entity\Users\User;
use Xpto\Service\Connections\Connection as ConnectionService;
use Xpto\Tests\CreateDatabaseMock;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Connection service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateDatabaseMock
     */
    use CreateDatabaseMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @var ConnectionService
     */
    private $service;

    public function setUp()
    {
        $this->service = new ConnectionService();

        $this->modifyAttribute($this->service, 'em', $this->getDefaultEmMock());
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Connections\Connection::setStatus()
     * @covers Xpto\Entity\Connections\Connection::isDeleted()
     * @covers Xpto\Service\Connections\Connection::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function save()
    {
        $connectionModel = new ConnectionModel();
        $result = $this->service->save($connectionModel);

        $this->assertSame($connectionModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Connections\Connection::isDeleted()
     * @covers Xpto\Entity\Connections\Connection::setStatus()
     * @covers Xpto\Service\Connections\Connection::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $connectionModel = new ConnectionModel();
        $result = $this->service->delete($connectionModel);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Xpto\Service\Connections\Connection::checkConnectivity()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Entity\Connections\Connection::setStatus()
     * @covers Xpto\Entity\Connections\Connection::setDestination()
     * @covers Xpto\Entity\Connections\Connection::setSource()
     * @covers Xpto\Entity\Entity::isDeleted()
     */
    public function checkConnectivity()
    {
        $source = new User();
        $destination = new User();

        $result = $this->service->checkConnectivity($source, $destination);

        $this->assertTrue(is_bool($result));
    }
}
