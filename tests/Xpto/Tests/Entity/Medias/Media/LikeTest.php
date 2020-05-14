<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Medias\Media;

use DateTime;
use Domain\Entity\Medias\Media;
use Domain\Entity\Users\User;
use Xpto\Entity\Medias\Media\Like;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Media test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class LikeTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return array
     */
    public function validObjects()
    {
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('isDeleted')->andReturn(false)->byDefault();

        $mediaMock = Mockery::mock(Media::class);
        $mediaMock->shouldReceive('isDeleted')->andReturn(false)->byDefault();
        $mediaMock->shouldReceive('getId')->andReturn(1)->byDefault();

        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime());
        $obj->updated = (new DateTime())->modify('+1 day');
        $obj->status = Like::NEWER;
        $obj->user = $userMock;
        $obj->media = $mediaMock;
        $obj->address = '127.0.0.1';
        $obj->agent = 'PHPUnit_Framework_TestCase';

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
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('isDeleted')->andReturn(true)->byDefault();

        $mediaMock = Mockery::mock(Media::class);
        $mediaMock->shouldReceive('isDeleted')->andReturn(true)->byDefault();
        $mediaMock->shouldReceive('getId')->andReturn(0)->byDefault();

        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime())->modify('+7 day');
        $obj->updated = (new DateTime())->modify('-20 day');
        $obj->status = 'true';
        $obj->user = $userMock;
        $obj->media = $mediaMock;
        $obj->address = '0';
        $obj->agent = '';

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
     * @covers       Xpto\Entity\Medias\Media\Like::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'id', $obj->id);

        $this->assertEquals($like->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'created', $obj->created);

        $this->assertSame($like->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $like = new Like();

        $result = $like->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $like = new Like();
        $like->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $like->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'created', $obj->created);

        $return = $like->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'created', $obj->created);

        $like->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $like = new Like();
        $like->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'status', $obj->status);

        $this->assertEquals($obj->status, $like->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $like = new Like();
        $like->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $like = new Like();
        $like->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $like = new Like();

        $result = $like->setStatus($like::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Like::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $like = new Like();

        $this->modifyAttribute($like, 'status', $like::NEWER);

        $this->assertTrue($like->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Like::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $like = new Like();

        $this->modifyAttribute($like, 'status', $like::ACTIVE);

        $this->assertTrue($like->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Like::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $like = new Like();

        $this->modifyAttribute($like, 'status', $like::DELETED);

        $this->assertTrue($like->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $like = new Like();

        $result = $like->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'status', Media::DELETED);

        $like->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::delete
     * @covers       Xpto\Entity\Medias\Media\Like::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $like = new Like();
        $like->delete();

        $this->assertTrue($like->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::delete
     * @covers       Xpto\Entity\Medias\Media\Like::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $like = new Like();
        $like->delete();

        $this->assertFalse($like->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::delete
     * @covers       Xpto\Entity\Medias\Media\Like::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $like = new Like();
        $like->delete();

        $this->assertFalse($like->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getUser()
     */
    public function getUserMustBeReturnUserAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'user', $obj->user);

        $this->assertSame($obj->user, $like->getUser());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setUser()
     * @covers       Xpto\Entity\Users\User::isDeleted()
     */
    public function setUserReturnEmptyWhenUserIsValid($obj)
    {
        $like = new Like();

        $result = $like->setUser($obj->user);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setUser()
     * @covers       Xpto\Entity\Users\User::isDeleted()
     *
     * @expectedException InvalidArgumentException
     */
    public function setUserReturnThrowsExceptionWhenUserIsDeleted($obj)
    {
        $like = new Like();
        $like->setUser($obj->user);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Like::getAddress()
     */
    public function getAddressMustReturnAddressAttribute()
    {
        $like = new Like();

        $this->modifyAttribute($like, 'address', 1);

        $this->assertEquals(1, $like->getAddress());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setAddress()
     */
    public function setAddressMustBeReturnEmptyWhenValidIP($obj)
    {
        $like = new Like();
        $result = $like->setAddress($obj->address);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setAddress()
     *
     * @expectedException InvalidArgumentException
     */
    public function setAddressThowsExceptionWhenInvalidIPAddress($obj)
    {
        $like = new Like();
        $like->setAddress($obj->address);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getAgent()
     */
    public function getAgentMustBeReturnAgentAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'agent', $obj->agent);

        $this->assertEquals($obj->agent, $like->getAgent());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setAgent()
     */
    public function setAgentMustBeReturnEmptyWhenAgentIsNotEmpty($obj)
    {
        $like = new Like();

        $result = $like->setAgent($obj->agent);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setAgent()
     *
     * @expectedException InvalidArgumentException
     */
    public function setAgentThrowsExceptionWhenEmpty($obj)
    {
        $like = new Like();
        $like->setAgent($obj->agent);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::getMedia()
     */
    public function getMediaReturnMediaAttribute($obj)
    {
        $like = new Like();

        $this->modifyAttribute($like, 'media', $obj->media);

        $this->assertSame($obj->media, $like->getMedia());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setMedia()
     * @covers       Xpto\Entity\Medias\Media::isDeleted()
     */
    public function setMediaReturnEmptyWhenMediaIsValid($obj)
    {
        $like = new Like();
        $result = $like->setMedia($obj->media);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Like::setMedia()
     * @covers       Xpto\Entity\Medias\Media::isDeleted()
     *
     * @expectedException InvalidArgumentException
     */
    public function setMediaThrowsExceptionWhenMediaIsDeleted($obj)
    {
        $like = new Like();
        $like->setMedia($obj->media);
    }
}
