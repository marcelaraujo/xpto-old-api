<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Inbox;

use Xpto\Entity\Inbox\Inbox;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Inbox test case.
 */
class InboxTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setSource()
     * @covers \Xpto\Entity\USers\User::isDeleted()
     */
    public function setSource()
    {
        $Inbox = new Inbox();
        $user = new User();

        $result = $Inbox->setSource($user);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::getStatusSource()
     */
    public function getStatusSource()
    {
        $Inbox = new Inbox();

        $this->modifyAttribute($Inbox, 'statusSource', 1);

        $this->assertEquals(1, $Inbox->getStatusSource());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::getDestination()
     */
    public function getDestination()
    {
        $Inbox = new Inbox();
        $destination = new User();

        $this->modifyAttribute($Inbox, 'destination', $destination);

        $this->assertSame($destination, $Inbox->getDestination());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setStatusSource()
     */
    public function setStatusSource()
    {
        $Inbox = new Inbox();

        $result = $Inbox->setStatusSource(Inbox::ACTIVE);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::getBody()
     */
    public function getBody()
    {
        $Inbox = new Inbox();

        $this->modifyAttribute($Inbox, 'body', 'oi');

        $this->assertEquals('oi', $Inbox->getBody());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setBody()
     */
    public function setBody()
    {
        $Inbox = new Inbox();

        $result = $Inbox->setBody('oi');

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setDestination()
     * @covers \Xpto\Entity\Users\User::isDeleted()
     */
    public function setDestination()
    {
        $Inbox = new Inbox();
        $user = new User();

        $result = $Inbox->setDestination($user);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::getSource()
     */
    public function getSource()
    {
        $Inbox = new Inbox();
        $source = new User();

        $this->modifyAttribute($Inbox, 'source', $source);

        $this->assertSame($source, $Inbox->getSource());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::getStatusDestination()
     */
    public function getStatusDestination()
    {
        $Inbox = new Inbox();

        $this->modifyAttribute($Inbox, 'statusDestination', 1);

        $this->assertEquals(1, $Inbox->getStatusDestination());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setStatusDestination()
     */
    public function setStatusDestination()
    {
        $Inbox = new Inbox();

        $result = $Inbox->setStatusDestination(1);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setDestination()
     * @covers \Xpto\Entity\Users\User::isDeleted()
     * @expectedException InvalidArgumentException
     */
    public function setDestinationThrowsInvalidArgumentExceptionWhenUserDestinationIsDeleted()
    {
        $Inbox = new Inbox();
        $user = new User();

        $this->modifyAttribute($user, 'status', User::DELETED);

        $Inbox->setDestination($user);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setSource()
     * @covers \Xpto\Entity\Users\User::isDeleted()
     * @expectedException InvalidArgumentException
     */
    public function setSourceThrowsInvalidArgumentExceptionWhenUserDestinationIsDeleted()
    {
        $Inbox = new Inbox();
        $user = new User();

        $this->modifyAttribute($user, 'status', User::DELETED);

        $Inbox->setSource($user);
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setBody()
     * @expectedException InvalidArgumentException
     */
    public function setBodyThrowsInvalidArgumentExceptionWhenEmpty()
    {
        $Inbox = new Inbox();
        $Inbox->setBody('');
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setStatusSource()
     * @expectedException InvalidArgumentException
     */
    public function setStatusSourceThrowsInvalidArgumentExceptionWhenStatusIsInvalid()
    {
        $Inbox = new Inbox();
        $Inbox->setStatusSource('active');
    }

    /**
     * @test
     * @covers \Xpto\Entity\Inbox\Inbox::setStatusDestination()
     * @expectedException InvalidArgumentException
     */
    public function setStatusDestinationThrowsInvalidArgumentExceptionWhenStatusIsInvalid()
    {
        $Inbox = new Inbox();
        $Inbox->setStatusDestination('active');
    }
}
