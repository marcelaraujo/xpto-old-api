<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Connections;

use DateTime;
use Xpto\Entity\Connections\Connection;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Connection test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $user1 = new User();
        $this->modifyAttribute($user1, 'id', 1);

        $user2 = new User();
        $this->modifyAttribute($user2, 'id', 2);

        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime());
        $obj->updated = (new DateTime())->modify('+1 day');
        $obj->birth = (new DateTime())->modify('-18 year');
        $obj->status = Connection::NEWER;
        $obj->source = $user1;
        $obj->destination = $user2;

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
        $user1 = new User();
        $this->modifyAttribute($user1, 'id', 1);

        $user2 = new User();
        $this->modifyAttribute($user2, 'id', 2);

        $obj = new stdClass();
        $obj->id = 'SS';
        $obj->created = (new DateTime())->modify('+3 day');
        $obj->updated = (new DateTime())->modify('-10 day');
        $obj->birth = (new DateTime())->modify('-1 hour');
        $obj->status = 'ok';
        $obj->source = $user1;
        $obj->destination = $user2;

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::setSource
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider validObjects
     */
    public function setSourceReturnEmptyWhenSourceIsValid($obj)
    {
        $connection = new Connection();
        $result = $connection->setSource($obj->source);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::setSource
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider invalidObjects
     *
     * @expectedException InvalidArgumentException
     */
    public function setSourceThrowsInvalidArgumentExceptionWhenSourceIsDeleted($obj)
    {
        $this->modifyAttribute($obj->source, 'status', User::DELETED);

        $connection = new Connection();
        $connection->setSource($obj->source);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::getSource
     *
     * @dataProvider validObjects
     */
    public function getSourceReturnSourceAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'source', $obj->source);

        $this->assertSame($connection->getSource(), $obj->source);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::setDestination
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider validObjects
     */
    public function setDestinationReturnEmptyWhenDestinationIsValid($obj)
    {
        $connection = new Connection();
        $result = $connection->setDestination($obj->destination);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::setDestination
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider invalidObjects
     *
     * @expectedException InvalidArgumentException
     */
    public function setDestinationThrowsInvalidArgumentExceptionWhenDestinationIsDeleted($obj)
    {
        $this->modifyAttribute($obj->destination, 'status', User::DELETED);

        $connection = new Connection();
        $connection->setDestination($obj->destination);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::getDestination
     *
     * @dataProvider validObjects
     */
    public function getDestinationReturnDestinationAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'destination', $obj->destination);

        $this->assertSame($connection->getDestination(), $obj->destination);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Connections\Connection::isApproved
     */
    public function isApprovedReturnBoolean()
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', Connection::APPROVED);

        $this->assertEquals($connection->isApproved(), Connection::APPROVED);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Connections\Connection::getId
     *
     * @dataProvider validObjects
     */
    public function getIdRetunsIdAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'id', $obj->id);

        $this->assertEquals($connection->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $this->assertSame($connection->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $connection = new Connection();

        $result = $connection->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $connection = new Connection();
        $connection->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $connection->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $return = $connection->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $connection->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $connection = new Connection();
        $connection->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', $obj->status);

        $this->assertEquals($obj->status, $connection->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $connection = new Connection();
        $connection->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $connection = new Connection();
        $connection->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $connection = new Connection();

        $result = $connection->setStatus($connection::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Connections\Connection::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', $connection::NEWER);

        $this->assertTrue($connection->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Connections\Connection::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', $connection::ACTIVE);

        $this->assertTrue($connection->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Connections\Connection::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', $connection::DELETED);

        $this->assertTrue($connection->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $connection = new Connection();

        $result = $connection->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $connection = new Connection();

        $this->modifyAttribute($connection, 'status', Connection::DELETED);

        $connection->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::delete
     * @covers       Xpto\Entity\Connections\Connection::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $connection = new Connection();
        $connection->delete();

        $this->assertTrue($connection->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::delete
     * @covers       Xpto\Entity\Connections\Connection::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $connection = new Connection();
        $connection->delete();

        $this->assertFalse($connection->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Connections\Connection::delete
     * @covers       Xpto\Entity\Connections\Connection::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $connection = new Connection();
        $connection->delete();

        $this->assertFalse($connection->isNewer());
    }
}
