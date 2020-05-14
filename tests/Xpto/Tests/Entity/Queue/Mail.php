<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Queue;

use Domain\Value\QueuePriority;
use Domain\Value\QueueType;
use Xpto\Entity\Queue\Mail;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class MailTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::getType()
     */
    public function getTypeReturnTypeAttribute()
    {
        $obj = new Mail();

        $this->modifyAttribute($obj, 'type', QueueType::SUBSCRIPTION);

        $this->assertEquals(QueueType::SUBSCRIPTION, $obj->getType());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setType()
     * @covers \Xpto\Entity\Queue\Mail::getType()
     */
    public function setTypeModifyTypeAttribute()
    {
        $obj = new Mail();
        $obj->setType(QueueType::SUBSCRIPTION);

        $this->assertEquals(QueueType::SUBSCRIPTION, $obj->getType());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setType()
     *
     * @expectedException InvalidArgumentException
     */
    public function setTypeOnlyAcceptNumericParameter()
    {
        $obj = new Mail();
        $obj->setType('S');
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::getContent()
     */
    public function getContentReturnContentAttribute()
    {
        $obj = new Mail();

        $this->modifyAttribute($obj, 'content', 'boo');

        $this->assertNotEmpty($obj->getContent());
        $this->assertEquals('boo', $obj->getContent());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setContent()
     * @covers \Xpto\Entity\Queue\Mail::getContent()
     */
    public function setContentModifyContentAttribute()
    {
        $obj = new Mail();
        $obj->setContent('boo');

        $this->assertEquals('boo', $obj->getContent());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setContent()
     *
     * @expectedException InvalidArgumentException
     */
    public function setContentThrowsExceptionWhenEmpty()
    {
        $obj = new Mail();
        $obj->setContent('');
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::getTitle()
     */
    public function getTitleReturnTitleAttribute()
    {
        $obj = new Mail();

        $this->modifyAttribute($obj, 'title', 'test');

        $this->assertEquals('test', $obj->getTitle());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setTitle()
     * @covers \Xpto\Entity\Queue\Mail::getTitle()
     */
    public function setTitleModifyTitleAttribute()
    {
        $obj = new Mail();
        $obj->setTitle('Test');

        $this->assertNotEmpty($obj->getTitle());
        $this->assertEquals('Test', $obj->getTitle());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setTitle()
     *
     * @expectedException InvalidArgumentException
     */
    public function setTitleThrowsExceptionWhenEmptyTitle()
    {
        $obj = new Mail();
        $obj->setTitle('');
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::getDestination()
     */
    public function getDestinationReturnsDestinationAttribute()
    {
        $obj = new Mail();

        $this->modifyAttribute($obj, 'destination', 'test@test.net');

        $this->assertEquals('test@test.net', $obj->getDestination());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setDestination()
     * @covers \Xpto\Entity\Queue\Mail::getDestination()
     */
    public function setDestinationModifyDestinationAttribute()
    {
        $obj = new Mail();
        $obj->setDestination('test@test.net');

        $this->assertNotEmpty($obj->getDestination());
        $this->assertEquals('test@test.net', $obj->getDestination());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setDestination()
     *
     * @expectedException InvalidArgumentException
     */
    public function setDestinationOnlyAcceptValidEmail()
    {
        $obj = new Mail();
        $obj->setDestination('test@test');
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setDestination()
     *
     * @expectedException InvalidArgumentException
     */
    public function setDestinationThrowsExceptionWhenEmpty()
    {
        $obj = new Mail();
        $obj->setDestination('');
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::getPriority()
     */
    public function getPriorityReturnPriorityAttribute()
    {
        $obj = new Mail();

        $this->modifyAttribute($obj, 'priority', QueuePriority::NORMAL);

        $this->assertEquals(QueuePriority::NORMAL, $obj->getPriority());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setPriority()
     * @covers \Xpto\Entity\Queue\Mail::getPriority()
     */
    public function setPriorityModifyPriorityAttribute()
    {
        $obj = new Mail();
        $obj->setPriority(QueuePriority::NORMAL);

        $this->assertNotEmpty($obj->getPriority());
        $this->assertEquals(QueuePriority::NORMAL, $obj->getPriority());
    }

    /**
     * @test
     *
     * @covers \Xpto\Entity\Queue\Mail::setPriority()
     *
     * @expectedException InvalidArgumentException
     */
    public function setPriorityOnlyAcceptNumericValue()
    {
        $obj = new Mail();
        $obj->setPriority('S');
    }
}
