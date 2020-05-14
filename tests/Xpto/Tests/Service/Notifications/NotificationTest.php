<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Notifications;

use Xpto\Service\Notifications\Notification as NotificationService;
use Xpto\Tests\ChangeProtectedAttribute;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Mockery as m;
use PHPUnit_Framework_TestCase;

/**
 * Notification service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class NotificationTest extends PHPUnit_Framework_TestCase
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
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Xpto\Service\Notifications\Notification::save()
     */
    public function save()
    {
        $model = m::mock('Domain\Entity\Notifications\Notification');

        $service = new NotificationService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->save($model);

        $this->assertSame($model, $result);
    }

    /**
     * @test
     * @covers Xpto\Service\Notifications\Notification::delete()
     * @covers Xpto\Service\Notifications\Notification::save()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Entity::isDeleted()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     */
    public function delete()
    {
        $model = m::mock('Domain\Entity\Notifications\Notification');
        $model->shouldReceive('isDeleted')->andReturn(false)->byDefault();
        $model->shouldReceive('setStatus')->andReturn(null)->byDefault();

        $service = new NotificationService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->delete($model);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Notifications\Notification::isDeleted()
     * @covers Xpto\Service\Notifications\Notification::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @expectedException InvalidArgumentException
     */
    public function deleteAlreadyDeletedThrowsException()
    {
        $model = m::mock('Domain\Entity\Notifications\Notification');
        $model->shouldReceive('isDeleted')->andReturn(true)->byDefault();

        $service = new NotificationService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $result = $service->delete($model);

        $this->assertTrue($result);
    }
}
