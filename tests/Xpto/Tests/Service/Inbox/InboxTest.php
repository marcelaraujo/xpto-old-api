<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Inbox;

use Xpto\Entity\Inbox\Inbox as InboxModel;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Inbox\Inbox as InboxService;
use Xpto\Tests\ChangeProtectedAttribute;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Mockery as m;
use PHPUnit_Framework_TestCase;

/**
 * Inbox service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class InboxTest extends PHPUnit_Framework_TestCase
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
     * @covers Xpto\Service\Inbox\Inbox::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Service\Connections\Connection::__construct()
     * @covers Xpto\Service\Connections\Connection::checkConnectivity()
     * @covers Xpto\Entity\Inbox\Inbox::getSource()
     * @covers Xpto\Entity\Inbox\Inbox::getDestination()
     * @covers Xpto\Entity\Entity::isDeleted()
     * @covers Xpto\Entity\Connections\Connection::setSource()
     * @covers Xpto\Entity\Connections\Connection::setDestination()
     * @covers Xpto\Entity\Connections\Connection::setStatus()
     * @covers Xpto\Service\Inbox\Inbox::archive()
     */
    public function save()
    {
        $connMock = m::mock('Domain\Service\Connections\Connection');
        $connMock
            ->shouldReceive('checkConnectivity')
            ->andReturn(true)
            ->byDefault();

        $inboxService = new InboxService();

        $this->modifyAttribute($inboxService, 'em', $this->getDefaultEmMock());

        $inboxModel = new InboxModel();

        $this->modifyAttribute($inboxModel, 'source', new UserModel());
        $this->modifyAttribute($inboxModel, 'destination', new UserModel());

        $result = $inboxService->save($inboxModel, $connMock);

        $this->assertSame($inboxModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Inbox\Inbox::setStatus()
     * @covers Xpto\Service\Inbox\Inbox::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Entity\Entity::isDeleted()
     */
    public function delete()
    {
        $inboxModel = new InboxModel();

        $inboxService = new InboxService();

        $this->modifyAttribute($inboxService, 'em', $this->getDefaultEmMock());

        $result = $inboxService->delete($inboxModel);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Inbox\Inbox::setStatus()
     * @covers Xpto\Service\Inbox\Inbox::archive()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function archive()
    {
        $inboxModel = new InboxModel();

        $inboxService = new InboxService();

        $this->modifyAttribute($inboxService, 'em', $this->getDefaultEmMock());

        $result = $inboxService->archive($inboxModel);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Inbox\Inbox::setStatus()
     * @covers Xpto\Service\Inbox\Inbox::markAsRead()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function markAsRead()
    {
        $inboxModel = new InboxModel();

        $inboxService = new InboxService();

        $this->modifyAttribute($inboxService, 'em', $this->getDefaultEmMock());

        $result = $inboxService->markAsRead($inboxModel);

        $this->assertTrue($result);
    }
}
