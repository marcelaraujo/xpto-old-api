<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Users;

use DateTime;
use Domain\Value\Category;
use Domain\Value\MediaType;
use Domain\Value\Work\Area as WorkArea;
use Domain\Value\Work\Type as WorkType;
use Xpto\Entity\Medias\Media;
use Xpto\Entity\Users\Customization;
use Xpto\Entity\Users\Profile;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Profile test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ProfileTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $custom = new Customization();

        $media = new Media();
        $media->setType(MediaType::IMAGE);

        $obj = new stdClass();
        $obj->id = 1;
        $obj->created = (new DateTime());
        $obj->updated = (new DateTime())->modify('+1 day');
        $obj->birth = (new DateTime())->modify('-18 year');
        $obj->status = Profile::NEWER;
        $obj->location = 'teste';
        $obj->nickname = 'teste';
        $obj->bioRelease = 'no no no no';
        $obj->fullRelease = 'no no no no';
        $obj->site = 'xpto';
        $obj->workType = WorkType::AGENCY;
        $obj->workArea = WorkArea::MODEL;
        $obj->category = Category::ART;
        $obj->customization = $custom;
        $obj->picture = $media;

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
        $media = new Media();
        $media->setType(MediaType::YOUTUBE);

        $obj = new stdClass();
        $obj->id = 'SS';
        $obj->created = (new DateTime())->modify('+3 day');
        $obj->updated = (new DateTime())->modify('-10 day');
        $obj->birth = (new DateTime())->modify('-1 hour');
        $obj->status = 'ok';
        $obj->location = '';
        $obj->nickname = '';
        $obj->bioRelease = '';
        $obj->fullRelease = '';
        $obj->site = 'lala@la.a';
        $obj->workType = '';
        $obj->workArea = '';
        $obj->category = '';
        $obj->customization = '';
        $obj->picture = $media;

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
     * @covers       Xpto\Entity\Users\Profile::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'id', $obj->id);

        $this->assertEquals($profile->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'created', $obj->created);

        $this->assertSame($profile->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $profile = new Profile();

        $result = $profile->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $profile = new Profile();
        $profile->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $profile->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'created', $obj->created);

        $return = $profile->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'created', $obj->created);

        $profile->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $profile = new Profile();
        $profile->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'status', $obj->status);

        $this->assertEquals($obj->status, $profile->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $profile = new Profile();
        $profile->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidstatus($obj)
    {
        $profile = new Profile();
        $profile->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $profile = new Profile();

        $result = $profile->setStatus($profile::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Profile::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'status', $profile::NEWER);

        $this->assertTrue($profile->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Profile::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'status', $profile::ACTIVE);

        $this->assertTrue($profile->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\Profile::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'status', $profile::DELETED);

        $this->assertTrue($profile->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $profile = new Profile();

        $result = $profile->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'status', Profile::DELETED);

        $profile->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::delete
     * @covers       Xpto\Entity\Users\Profile::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $profile = new Profile();
        $profile->delete();

        $this->assertTrue($profile->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::delete
     * @covers       Xpto\Entity\Users\Profile::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $profile = new Profile();
        $profile->delete();

        $this->assertFalse($profile->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::delete
     * @covers       Xpto\Entity\Users\Profile::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $profile = new Profile();
        $profile->delete();

        $this->assertFalse($profile->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setBirth
     */
    public function setBirthResultEmptyWhenSuccess($obj)
    {
        $profile = new Profile();
        $result = $profile->setBirth($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setBirth
     */
    public function setBirthResultEmptyWhenBirthOnThePast($obj)
    {
        $profile = new Profile();
        $result = $profile->setBirth($obj->birth);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setBirth
     *
     * @expectedException InvalidArgumentException
     */
    public function setBirthThrowsInvalidArgumentExceptionWhenBirthOnTheFuture($obj)
    {
        $profile = new Profile();
        $profile->setBirth($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getLocationLive
     */
    public function getLocationLiveReturnLocationLiveAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'locationLive', $obj->location);

        $this->assertEquals($profile->getLocationLive(), $obj->location);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setLocationLive
     */
    public function setLocationLiveReturnEmptyWhenLocationLiveIsValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setLocationLive($obj->location);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setLocationLive
     *
     * @expectedException InvalidArgumentException
     */
    public function setLocationLiveThrowsInvalidArgumentExceptionWhenLocationLiveEmpty($obj)
    {
        $profile = new Profile();
        $profile->setLocationLive($obj->location);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getLocationBorn
     */
    public function getLocationBornReturnLocationBornAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'locationBorn', $obj->location);

        $this->assertEquals($profile->getLocationBorn(), $obj->location);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setLocationBorn
     */
    public function setLocationBornReturnEmptyWhenLocationBornIsValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setLocationBorn($obj->location);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setLocationBorn
     *
     * @expectedException InvalidArgumentException
     */
    public function setLocationBornThrowsInvalidArgumentExceptionWhenLocationBornEmpty($obj)
    {
        $profile = new Profile();
        $profile->setLocationBorn($obj->location);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getNickname
     */
    public function getNicknameReturnNicknameAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'nickname', $obj->nickname);

        $this->assertEquals($profile->getNickname(), $obj->nickname);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setNickname
     *
     * @expectedException InvalidArgumentException
     */
    public function setNicknameThrowsInvalidArgumentExceptionWhenNicknameEmpty($obj)
    {
        $profile = new Profile();
        $profile->setNickname($obj->nickname);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setNickname
     */
    public function setNicknameReturnEmptyWhenNicknameIsValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setNickname($obj->nickname);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getBioRelease
     */
    public function getBioReleaseReturnBioReleaseAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'bioRelease', $obj->bioRelease);

        $this->assertEquals($profile->getBioRelease(), $obj->bioRelease);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setBioRelease
     *
     * @expectedException InvalidArgumentException
     */
    public function setBioReleaseThrowsInvalidArgumentExceptionWhenBioReleaseEmpty($obj)
    {
        $profile = new Profile();
        $profile->setBioRelease($obj->bioRelease);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setBioRelease
     */
    public function setBioReleaseReturnEmptyWhenBioReleaseIsValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setBioRelease($obj->bioRelease);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getFullRelease
     */
    public function getFullReleaseReturnFullReleaseAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'fullRelease', $obj->fullRelease);

        $this->assertEquals($profile->getFullRelease(), $obj->fullRelease);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setFullRelease
     *
     * @expectedException InvalidArgumentException
     */
    public function setFullReleaseThrowsInvalidArgumentExceptionWhenFullReleaseEmpty($obj)
    {
        $profile = new Profile();
        $profile->setFullRelease($obj->fullRelease);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setFullRelease
     */
    public function setFullReleaseReturnEmptyWhenFullReleaseIsValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setFullRelease($obj->fullRelease);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getSite
     */
    public function getSiteReturnSiteAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'site', $obj->site);

        $this->assertEquals($profile->getSite(), $obj->site);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setSite
     */
    public function setSiteReturnEmptyWhenSiteValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setSite($obj->site);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setSite
     *
     * @expectedException InvalidArgumentException
     */
    public function setSiteThrowsInvalidArgumentExceptionWhenDomainInvalid($obj)
    {
        $profile = new Profile();
        $profile->setSite($obj->site);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getWorkType
     */
    public function getWorkTypeReturnWorkAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'workType', $obj->workType);

        $this->assertEquals($profile->getWorkType(), $obj->workType);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setWorkType
     */
    public function setWorkTypeReturnEmptyWhenWorkValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setWorkType($obj->workType);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setWorkType
     *
     * @expectedException InvalidArgumentException
     */
    public function setWorkTypeThrowsInvalidArgumentExceptionWhenDomainInvalid($obj)
    {
        $profile = new Profile();
        $profile->setWorkType($obj->workType);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getCategory
     */
    public function getCategoryReturnWorkAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'category', $obj->category);

        $this->assertEquals($profile->getCategory(), $obj->category);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setCategory
     */
    public function setCategoryReturnEmptyWhenCategoryValid($obj)
    {
        $profile = new Profile();
        $result = $profile->setCategory($obj->category);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Profile::setCategory
     *
     * @expectedException InvalidArgumentException
     */
    public function setCategoryThrowsInvalidArgumentExceptionWhenDomainInvalid($obj)
    {
        $profile = new Profile();
        $profile->setCategory($obj->category);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getCustomization
     */
    public function getCustomizationReturnCustomizationAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'customization', $obj->customization);

        $this->assertEquals($profile->getCustomization(), $obj->customization);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Customization::isDeleted
     * @covers       Xpto\Entity\Users\Profile::setCustomization
     */
    public function setCustomizationReturnEmptyWhenCustomizationValid($obj)
    {
        $profile = new Profile();
        $customization = new Customization();

        $result = $profile->setCustomization($customization);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\Customization::isDeleted
     * @covers       Xpto\Entity\Users\Profile::setCustomization
     *
     * @expectedException InvalidArgumentException
     */
    public function setCustomizationThrowsInvalidArgumentExceptionWhenCustomizationIsDeleted($obj)
    {
        $profile = new Profile();
        $customization = new Customization();

        $this->modifyAttribute($customization, 'status', Customization::DELETED);

        $profile->setCustomization($customization);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\Profile::getPicture
     */
    public function getPictureReturnPictureAttribute($obj)
    {
        $profile = new Profile();

        $this->modifyAttribute($profile, 'picture', $obj->picture);

        $this->assertEquals($profile->getPicture(), $obj->picture);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Medias\Media::getType
     * @covers       Xpto\Entity\Medias\Media::isDeleted
     * @covers       Xpto\Entity\Users\Profile::setPicture
     */
    public function setCPictureReturnEmptyWhenMediaIsValid($obj)
    {
        $profile = new Profile();

        $result = $profile->setPicture($obj->picture);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Medias\Media::isDeleted
     * @covers       Xpto\Entity\Medias\Media::getType
     * @covers       Xpto\Entity\Users\Profile::setPicture
     *
     * @expectedException InvalidArgumentException
     */
    public function setPictureThrowsInvalidArgumentExceptionWhenPictureIsDeleted($obj)
    {
        $profile = new Profile();

        $profile->setPicture($obj->picture);
    }
}
