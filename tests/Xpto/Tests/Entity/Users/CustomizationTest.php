<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Users;

use DateTime;
use Xpto\Entity\Users\Customization;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Customization test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class CustomizationTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime());
        $obj->updated = (new DateTime())->modify('+1 day');
        $obj->birth = (new DateTime())->modify('-18 year');
        $obj->status = Customization::NEWER;
        $obj->enter = true;
        $obj->type = 1;

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @return multitype:multitype:number
     */
    public function invalidObjects()
    {
        $obj = new stdClass();
        $obj->id = 'SS';
        $obj->created = (new DateTime())->modify('+3 day');
        $obj->updated = (new DateTime())->modify('-10 day');
        $obj->birth = (new DateTime())->modify('-1 hour');
        $obj->status = 'ok';
        $obj->enter = 'true';
        $obj->type = 'Modelo';

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'id', $obj->id);

        $this->assertEquals($customization->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'created', $obj->created);

        $this->assertSame($customization->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $customization = new Customization();

        $result = $customization->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $customization = new Customization();
        $customization->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $customization->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'created', $obj->created);

        $return = $customization->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'created', $obj->created);

        $customization->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $customization = new Customization();
        $customization->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', $obj->status);

        $this->assertEquals($obj->status, $customization->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $customization = new Customization();
        $customization->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $customization = new Customization();
        $customization->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $customization = new Customization();

        $result = $customization->setStatus($customization::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Customization::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', $customization::NEWER);

        $this->assertTrue($customization->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Customization::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', $customization::ACTIVE);

        $this->assertTrue($customization->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Customization::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', $customization::DELETED);

        $this->assertTrue($customization->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $customization = new Customization();

        $result = $customization->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', Customization::DELETED);

        $customization->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::delete
     * @covers       Xpto\Entity\Users\Customization::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $customization = new Customization();
        $customization->delete();

        $this->assertTrue($customization->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::delete
     * @covers       Xpto\Entity\Users\Customization::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $customization = new Customization();
        $customization->delete();

        $this->assertFalse($customization->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::delete
     * @covers       Xpto\Entity\Users\Customization::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $customization = new Customization();
        $customization->delete();

        $this->assertFalse($customization->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setSendWithEnter
     */
    public function setSendWithEnterReturnEmptyWhenReceiveBoolean($obj)
    {
        $customization = new Customization();

        $result = $customization->setSendWithEnter($obj->enter);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setSendWithEnter
     *
     * @expectedException InvalidArgumentException
     */
    public function setSendWithEnterThrowsInvalidArgumentExceptionWhenReceiveNotBooleanParameter($obj)
    {
        $customization = new Customization();
        $customization->setSendWithEnter($obj->enter);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getSendWithEnter
     */
    public function getSendWithEnterReturnSendWithEnterProperty($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'sendWithEnter', $obj->enter);

        $this->assertEquals($customization->getSendWithEnter(), $obj->enter);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setType
     */
    public function setTypeReturnEmptyWhenReceiveAnInteger($obj)
    {
        $customization = new Customization();
        $result = $customization->setType($obj->type);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::setType
     *
     * @expectedException InvalidArgumentException
     */
    public function setTypeThrowsInvalidArgumentExceptionWhenReceiveNotNumericParameter($obj)
    {
        $customization = new Customization();
        $result = $customization->setType($obj->type);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::getType
     */
    public function getTypeReturnTypeAttribute($obj)
    {
        $customization = new Customization();

        $this->modifyAttribute($customization, 'type', $obj->type);

        $this->assertEquals($customization->getType(), $obj->type);
    }
}
