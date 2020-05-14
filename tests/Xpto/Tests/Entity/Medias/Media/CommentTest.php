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
use Xpto\Entity\Medias\Media\Comment;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Media test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class CommentTest extends PHPUnit_Framework_TestCase
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
        $obj->status = Comment::NEWER;
        $obj->user = $userMock;
        $obj->media = $mediaMock;
        $obj->address = '127.0.0.1';
        $obj->agent = 'PHPUnit_Framework_TestCase';
        $obj->comment = 'Hello world, É nós! :)';

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
        $obj->comment = ' ';

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
     * @covers       Xpto\Entity\Medias\Media\Comment::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'id', $obj->id);

        $this->assertEquals($comment->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'created', $obj->created);

        $this->assertSame($comment->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $comment = new Comment();

        $result = $comment->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $comment = new Comment();
        $comment->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $comment->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'created', $obj->created);

        $return = $comment->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'created', $obj->created);

        $comment->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $comment = new Comment();
        $comment->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'status', $obj->status);

        $this->assertEquals($obj->status, $comment->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $comment = new Comment();
        $comment->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $comment = new Comment();
        $comment->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $comment = new Comment();

        $result = $comment->setStatus($comment::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Comment::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'status', $comment::NEWER);

        $this->assertTrue($comment->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Comment::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'status', $comment::ACTIVE);

        $this->assertTrue($comment->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Comment::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'status', $comment::DELETED);

        $this->assertTrue($comment->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $comment = new Comment();

        $result = $comment->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'status', Media::DELETED);

        $comment->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::delete
     * @covers       Xpto\Entity\Medias\Media\Comment::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $comment = new Comment();
        $comment->delete();

        $this->assertTrue($comment->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::delete
     * @covers       Xpto\Entity\Medias\Media\Comment::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $comment = new Comment();
        $comment->delete();

        $this->assertFalse($comment->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::delete
     * @covers       Xpto\Entity\Medias\Media\Comment::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $comment = new Comment();
        $comment->delete();

        $this->assertFalse($comment->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getUser()
     */
    public function getUserMustBeReturnUserAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'user', $obj->user);

        $this->assertSame($obj->user, $comment->getUser());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setUser()
     * @covers       Xpto\Entity\Users\User::isDeleted()
     */
    public function setUserReturnEmptyWhenUserIsValid($obj)
    {
        $comment = new Comment();

        $result = $comment->setUser($obj->user);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setUser()
     * @covers       Xpto\Entity\Users\User::isDeleted()
     *
     * @expectedException InvalidArgumentException
     */
    public function setUserReturnThrowsExceptionWhenUserIsDeleted($obj)
    {
        $comment = new Comment();
        $comment->setUser($obj->user);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media\Comment::getAddress()
     */
    public function getAddressMustReturnAddressAttribute()
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'address', 1);

        $this->assertEquals(1, $comment->getAddress());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setAddress()
     */
    public function setAddressMustBeReturnEmptyWhenValidIP($obj)
    {
        $comment = new Comment();
        $result = $comment->setAddress($obj->address);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setAddress()
     *
     * @expectedException InvalidArgumentException
     */
    public function setAddressThowsExceptionWhenInvalidIPAddress($obj)
    {
        $comment = new Comment();
        $comment->setAddress($obj->address);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getAgent()
     */
    public function getAgentMustBeReturnAgentAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'agent', $obj->agent);

        $this->assertEquals($obj->agent, $comment->getAgent());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setAgent()
     */
    public function setAgentMustBeReturnEmptyWhenAgentIsNotEmpty($obj)
    {
        $comment = new Comment();

        $result = $comment->setAgent($obj->agent);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setAgent()
     *
     * @expectedException InvalidArgumentException
     */
    public function setAgentThrowsExceptionWhenEmpty($obj)
    {
        $comment = new Comment();
        $comment->setAgent($obj->agent);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getMedia()
     */
    public function getMediaReturnMediaAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'media', $obj->media);

        $this->assertSame($obj->media, $comment->getMedia());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setMedia()
     * @covers       Xpto\Entity\Medias\Media::isDeleted()
     */
    public function setMediaReturnEmptyWhenMediaIsValid($obj)
    {
        $comment = new Comment();
        $result = $comment->setMedia($obj->media);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setMedia()
     * @covers       Xpto\Entity\Medias\Media::isDeleted()
     *
     * @expectedException InvalidArgumentException
     */
    public function setMediaThrowsExceptionWhenMediaIsDeleted($obj)
    {
        $comment = new Comment();
        $comment->setMedia($obj->media);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::getContent()
     */
    public function getContentMustReturnContentAttribute($obj)
    {
        $comment = new Comment();

        $this->modifyAttribute($comment, 'content', $obj->comment);

        $this->assertEquals($obj->comment, $comment->getContent());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setContent()
     */
    public function setContentReturnEmptyWhenContentIsValid($obj)
    {
        $comment = new Comment();
        $result = $comment->setContent($obj->comment);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media\Comment::setContent()
     *
     * @expectedException InvalidArgumentException
     */
    public function setContentThrowsExceptionWhenContentIsLowerThanTwoChars($obj)
    {
        $comment = new Comment();
        $comment->setContent($obj->comment);
    }
}
