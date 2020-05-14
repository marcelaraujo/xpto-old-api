<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Recommendations;

use DateTime;
use Xpto\Entity\Recommendations\Recommendation;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Recommendation test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class RecommendationTest extends PHPUnit_Framework_TestCase
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
        $obj->status = Recommendation::NEWER;
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
     * @covers       Xpto\Entity\Recommendations\Recommendation::setSource
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider validObjects
     */
    public function setSourceReturnEmptyWhenSourceIsValid($obj)
    {
        $connection = new Recommendation();
        $result = $connection->setSource($obj->source);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setSource
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider invalidObjects
     *
     * @expectedException InvalidArgumentException
     */
    public function setSourceThrowsInvalidArgumentExceptionWhenSourceIsDeleted($obj)
    {
        $this->modifyAttribute($obj->source, 'status', User::DELETED);

        $connection = new Recommendation();
        $connection->setSource($obj->source);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getSource
     *
     * @dataProvider validObjects
     */
    public function getSourceReturnSourceAttribute($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'source', $obj->source);

        $this->assertSame($connection->getSource(), $obj->source);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setDestination
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider validObjects
     */
    public function setRecommendedReturnEmptyWhenRecommendedIsValid($obj)
    {
        $connection = new Recommendation();
        $result = $connection->setDestination($obj->destination);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setDestination
     * @covers       Xpto\Entity\Users\User::isDeleted
     *
     * @dataProvider invalidObjects
     *
     * @expectedException InvalidArgumentException
     */
    public function setRecommendedThrowsInvalidArgumentExceptionWhenRecommendedIsDeleted($obj)
    {
        $this->modifyAttribute($obj->destination, 'status', User::DELETED);

        $connection = new Recommendation();
        $connection->setDestination($obj->destination);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getDestination
     *
     * @dataProvider validObjects
     */
    public function getRecommendedReturnRecommendedAttribute($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'destination', $obj->destination);

        $this->assertSame($connection->getDestination(), $obj->destination);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Recommendations\Recommendation::isApproved
     */
    public function isApprovedReturnBoolean()
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'status', Recommendation::APPROVED);

        $this->assertEquals($connection->isApproved(), Recommendation::APPROVED);
    }

    /**
     * @test
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getId
     *
     * @dataProvider validObjects
     */
    public function getIdRetunsIdAttribute($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'id', $obj->id);

        $this->assertEquals($connection->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $this->assertSame($connection->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $connection = new Recommendation();

        $result = $connection->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $connection = new Recommendation();
        $connection->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $connection->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $return = $connection->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'created', $obj->created);

        $connection->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $connection = new Recommendation();
        $connection->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $connection = new Recommendation();

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
     * @covers       Xpto\Entity\Recommendations\Recommendation::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $connection = new Recommendation();
        $connection->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $connection = new Recommendation();
        $connection->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $connection = new Recommendation();

        $result = $connection->setStatus($connection::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Recommendations\Recommendation::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'status', $connection::NEWER);

        $this->assertTrue($connection->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Recommendations\Recommendation::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'status', $connection::ACTIVE);

        $this->assertTrue($connection->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Recommendations\Recommendation::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'status', $connection::DELETED);

        $this->assertTrue($connection->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $connection = new Recommendation();

        $result = $connection->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $connection = new Recommendation();

        $this->modifyAttribute($connection, 'status', Recommendation::DELETED);

        $connection->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::delete
     * @covers       Xpto\Entity\Recommendations\Recommendation::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $connection = new Recommendation();
        $connection->delete();

        $this->assertTrue($connection->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::delete
     * @covers       Xpto\Entity\Recommendations\Recommendation::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $connection = new Recommendation();
        $connection->delete();

        $this->assertFalse($connection->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Recommendations\Recommendation::delete
     * @covers       Xpto\Entity\Recommendations\Recommendation::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $connection = new Recommendation();
        $connection->delete();

        $this->assertFalse($connection->isNewer());
    }
}
