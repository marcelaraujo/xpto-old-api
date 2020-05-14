<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Notifications;

use Domain\Value\NotificationType;
use Xpto\Entity\Notifications\Notification;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Notification test case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class NotificationTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::getType()
     */
    public function getTypeReturnTypeAttribute()
    {
        $notification = new Notification();

        $this->modifyAttribute($notification, 'type', NotificationType::INFO);

        $this->assertEquals(NotificationType::INFO, $notification->getType());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setType()
     */
    public function setType()
    {
        $notification = new Notification();
        $result = $notification->setType(NotificationType::INFO);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setType()
     * @expectedException InvalidArgumentException
     */
    public function setTypeTrowsExceptionWhenInvalidType()
    {
        $notification = new Notification();
        $result = $notification->setType('S');

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::getContent()
     */
    public function getContentReturnContentAttribute()
    {
        $notification = new Notification();

        $this->modifyAttribute($notification, 'content', 'foo');

        $this->assertEquals('foo', $notification->getContent());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setContent()
     */
    public function setContent()
    {
        $notification = new Notification();
        $result = $notification->setContent('foo');

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setContent()
     * @expectedException InvalidArgumentException
     */
    public function setContentThrowsInvalidArgumentExceptionWhenEmpty()
    {
        $notification = new Notification();
        $notification->setContent('');
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::getUser()
     */
    public function getUserReturnUserAttribute()
    {
        $notification = new Notification();

        $userMock = Mockery::mock('\Domain\Entity\Users\User');

        $this->modifyAttribute($notification, 'user', $userMock);

        $this->assertSame($userMock, $notification->getUser());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setUser()
     */
    public function setUser()
    {
        $userMock = Mockery::mock('\Domain\Entity\Users\User');
        $userMock->shouldReceive('isDeleted')->andReturn(false)->byDefault();

        $notification = new Notification();
        $result = $notification->setUser($userMock);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Notifications\Notification::setUser()
     * @expectedException InvalidArgumentException
     */
    public function setUserThrowsExceptionWhenUserIsAlreadyDeleted()
    {
        $userMock = Mockery::mock('\Domain\Entity\Users\User');
        $userMock->shouldReceive('isDeleted')->andReturn(true)->byDefault();

        $notification = new Notification();
        $result = $notification->setUser($userMock);
    }
}
