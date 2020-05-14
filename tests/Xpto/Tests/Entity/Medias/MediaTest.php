<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Medias;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Domain\Value\MediaType;
use Xpto\Entity\Medias\Media;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Media test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class MediaTest extends PHPUnit_Framework_TestCase
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
        $obj->status = Media::NEWER;
        $obj->details = new ArrayCollection([
            new Media\Detail(),
            new Media\Detail(),
            new Media\Detail()
        ]);
        $obj->type = MediaType::IMAGE;
        $obj->url = 'http://www.google.com.br';

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
        $obj->status = 'ok';
        $obj->details = '';
        $obj->type = 'image';
        $obj->url = '';

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
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'id', $obj->id);

        $this->assertEquals($media->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'created', $obj->created);

        $this->assertSame($media->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $media = new Media();

        $result = $media->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $media = new Media();
        $media->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $media->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'created', $obj->created);

        $return = $media->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'created', $obj->created);

        $media->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $media = new Media();
        $media->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'status', $obj->status);

        $this->assertEquals($obj->status, $media->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $media = new Media();
        $media->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $media = new Media();
        $media->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $media = new Media();

        $result = $media->setStatus($media::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media::__construct
     * @covers Xpto\Entity\Medias\Media::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $media = new Media();

        $this->modifyAttribute($media, 'status', $media::NEWER);

        $this->assertTrue($media->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media::__construct
     * @covers Xpto\Entity\Medias\Media::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $media = new Media();

        $this->modifyAttribute($media, 'status', $media::ACTIVE);

        $this->assertTrue($media->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Medias\Media::__construct
     * @covers Xpto\Entity\Medias\Media::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $media = new Media();

        $this->modifyAttribute($media, 'status', $media::DELETED);

        $this->assertTrue($media->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $media = new Media();

        $result = $media->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'status', Media::DELETED);

        $media->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::delete
     * @covers       Xpto\Entity\Medias\Media::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $media = new Media();
        $media->delete();

        $this->assertTrue($media->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::delete
     * @covers       Xpto\Entity\Medias\Media::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $media = new Media();
        $media->delete();

        $this->assertFalse($media->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::delete
     * @covers       Xpto\Entity\Medias\Media::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $media = new Media();
        $media->delete();

        $this->assertFalse($media->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::getDetails
     */
    public function getDetailsReturnsDetailProperty($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'details', $obj->details);

        $this->assertEquals($media->getDetails(), $obj->details);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setDetails
     */
    public function setDetailsReturnEmptyOnSuccess($obj)
    {
        $media = new Media();

        $result = $media->setDetails($obj->details);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct
     * @covers       Xpto\Entity\Medias\Media::setType
     */
    public function setTypeReturnEmptyWhenReceiveAnInteger($obj)
    {
        $media = new Media();
        $result = $media->setType($obj->type);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct()
     * @covers       Xpto\Entity\Medias\Media::setType()
     *
     * @expectedException InvalidArgumentException
     */
    public function setTypeThrowsInvalidArgumentExceptionWhenReceiveNotNumericParameter($obj)
    {
        $media = new Media();
        $result = $media->setType($obj->type);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::__construct()
     * @covers       Xpto\Entity\Medias\Media::getType()
     */
    public function getTypeReturnTypeAttribute($obj)
    {
        $media = new Media();

        $this->modifyAttribute($media, 'type', $obj->type);

        $this->assertEquals($media->getType(), $obj->type);
    }
}
