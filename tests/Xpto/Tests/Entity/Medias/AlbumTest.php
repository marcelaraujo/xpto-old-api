<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Medias;

use DateTime;
use Xpto\Entity\Medias\Album;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Album test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class AlbumTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $user = new User();
        $this->modifyAttribute($user, 'status', User::NEWER);

        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime());
        $obj->updated = (new DateTime())->modify('+1 day');
        $obj->status = Album::NEWER;
        $obj->title = 'Teste';
        $obj->cover = 1;
        $obj->user = $user;

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
        $user = new User();
        $this->modifyAttribute($user, 'status', User::DELETED);

        $obj = new stdClass();
        $obj->id = 'SS';
        $obj->created = (new DateTime())->modify('+3 day');
        $obj->updated = (new DateTime())->modify('-10 day');
        $obj->status = 'ok';
        $obj->title = '';
        $obj->cover = 's';
        $obj->user = $user;

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
     * @covers       Xpto\Entity\Albums\Album::getId
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'id', $obj->id);

        $this->assertEquals($album->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getCreated
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'created', $obj->created);

        $this->assertSame($album->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setCreated
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setCreateReturnEmpty($obj)
    {
        $album = new Album();

        $result = $album->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setCreated
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $album = new Album();
        $album->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getUpdated
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $album->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setUpdated
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'created', $obj->created);

        $return = $album->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setUpdated
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'created', $obj->created);

        $album->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setUpdated
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $album = new Album();
        $album->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getStatus
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'status', $obj->status);

        $this->assertEquals($obj->status, $album->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setStatus
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $album = new Album();
        $album->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setStatus
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $album = new Album();
        $album->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setStatus
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setStatusReturnsEmpty($obj)
    {
        $album = new Album();

        $result = $album->setStatus($album::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Albums\Album::isNewer
     * @covers Xpto\Entity\Albums\Album::__construct
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $album = new Album();

        $this->modifyAttribute($album, 'status', $album::NEWER);

        $this->assertTrue($album->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Albums\Album::isActive
     * @covers Xpto\Entity\Albums\Album::__construct
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $album = new Album();

        $this->modifyAttribute($album, 'status', $album::ACTIVE);

        $this->assertTrue($album->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Albums\Album::isDeleted
     * @covers Xpto\Entity\Albums\Album::__construct
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $album = new Album();

        $this->modifyAttribute($album, 'status', $album::DELETED);

        $this->assertTrue($album->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::delete
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $album = new Album();

        $result = $album->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::delete
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'status', Album::DELETED);

        $album->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::delete
     * @covers       Xpto\Entity\Albums\Album::isDeleted
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $album = new Album();
        $album->delete();

        $this->assertTrue($album->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::delete
     * @covers       Xpto\Entity\Albums\Album::isActive
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $album = new Album();
        $album->delete();

        $this->assertFalse($album->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::delete
     * @covers       Xpto\Entity\Albums\Album::isNewer
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $album = new Album();
        $album->delete();

        $this->assertFalse($album->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setTitle
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setTitleReturnEmptyOnSuccess($obj)
    {
        $album = new Album();

        $result = $album->setTitle($obj->title);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setTitle
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException InvalidArgumentException
     */
    public function setTitleThrowsExceptionWhenEmpty($obj)
    {
        $album = new Album();
        $album->setTitle($obj->title);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getTitle
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getTitleReturnTitleAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'title', $obj->title);

        $this->assertEquals($album->getTitle(), $obj->title);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setCover
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setCoverReturnEmptyOnSuccess($obj)
    {
        $album = new Album();

        $result = $album->setCover($obj->cover);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getCover
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getCoverReturnCoverAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'cover', $obj->cover);

        $this->assertSame($album->getCover(), $obj->cover);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setUser
     * @covers       Xpto\Entity\Users\User::getId
     * @covers       Xpto\Entity\Users\User::isDeleted
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function setUserReturnEmptyOnSuccess($obj)
    {
        $album = new Album();

        $result = $album->setUser($obj->user);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Albums\Album::setUser
     * @covers       Xpto\Entity\Users\User::getId
     * @covers       Xpto\Entity\Users\User::isDeleted
     * @covers       Xpto\Entity\Albums\Album::__construct
     *
     * @expectedException InvalidArgumentException
     */
    public function setUserThrowsExceptionWhenUserIsDeleted($obj)
    {
        $album = new Album();
        $album->setUser($obj->user);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Albums\Album::getUser
     * @covers       Xpto\Entity\Albums\Album::__construct
     */
    public function getUserReturnUserAttribute($obj)
    {
        $album = new Album();

        $this->modifyAttribute($album, 'user', $obj->user);

        $this->assertSame($album->getUser(), $obj->user);
    }
}
