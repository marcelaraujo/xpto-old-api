<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Users;

use DateTime;
use Domain\Value\UserType;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * User test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
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
        $obj->status = User::NEWER;
        $obj->name = 'Teste';
        $obj->email = 'teste@teste.net';
        $obj->password = 'xxxxx';
        $obj->type = UserType::CREATIVE;

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
        $obj->name = '';
        $obj->email = 'lalala';
        $obj->emailVoid = '';
        $obj->password = '';
        $obj->type = '';

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
     * @covers       Xpto\Entity\Users\User::getId
     */
    public function getIdShouldReturnTheIdAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'id', $obj->id);

        $this->assertEquals($user->getId(), $obj->id);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getCreated
     */
    public function getCreateReturnCreateAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'created', $obj->created);

        $this->assertSame($user->getCreated(), $obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setCreated
     */
    public function setCreateReturnEmpty($obj)
    {
        $user = new User();

        $result = $user->setCreated($obj->created);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setCreated
     *
     * @expectedException InvalidArgumentException
     */
    public function setCreateThrowsExceptionWhenDateOnTheFuture($obj)
    {
        $user = new User();
        $user->setCreated($obj->created);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getUpdated
     */
    public function getUpdateShouldReturnTheUpdateAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'updated', $obj->updated);

        $this->assertSame($obj->updated, $user->getUpdated());
    }

    /**
     * @test
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setUpdated
     */
    public function setUpdateReturnEmptyWhenSuccess($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'created', $obj->created);

        $return = $user->setUpdated($obj->updated, $obj->updated);

        $this->assertEmpty($return);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenLowerThanCreate($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'created', $obj->created);

        $user->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setUpdated
     *
     * @expectedException InvalidArgumentException
     */
    public function setUpdateThrowsExceptionWhenCreateIsNull($obj)
    {
        $user = new User();
        $user->setUpdated($obj->updated);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getStatus
     */
    public function getStatusShouldReturnTheStatusAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'status', $obj->status);

        $this->assertEquals($obj->status, $user->getStatus());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setStatus
     */
    public function setStatusThrowsExceptionWhenNotIntegerStatus($obj)
    {
        $user = new User();
        $user->setStatus($obj->status);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setStatus
     */
    public function setStatusThrowsExceptionWhenInvalidStatus($obj)
    {
        $user = new User();
        $user->setStatus(1000);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setStatus
     */
    public function setStatusReturnsEmpty($obj)
    {
        $user = new User();

        $result = $user->setStatus($user::ACTIVE);

        $this->assertempty($result);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\User::isNewer
     */
    public function isNewerReturnTrueWhenObjectOnNewerStatus()
    {
        $user = new User();

        $this->modifyAttribute($user, 'status', $user::NEWER);

        $this->assertTrue($user->isNewer());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\User::isActive
     */
    public function isActiveReturnTrueWhenObjectOnActiveStatus()
    {
        $user = new User();

        $this->modifyAttribute($user, 'status', $user::ACTIVE);

        $this->assertTrue($user->isActive());
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\User::isDeleted
     */
    public function isDeletedReturnTrueWhenObjectOnDeletedStatus()
    {
        $user = new User();

        $this->modifyAttribute($user, 'status', $user::DELETED);

        $this->assertTrue($user->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::delete
     */
    public function deleteReturnTrueWhenSuccess($obj)
    {
        $user = new User();

        $result = $user->delete();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::delete
     *
     * @expectedException OutOfBoundsException
     */
    public function deleteThrowsExceptionWhenAlreadyDeleted($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'status', User::DELETED);

        $user->delete();
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::delete
     * @covers       Xpto\Entity\Users\User::isDeleted
     */
    public function isDeletedReturnTrueAfterDeleteMethod($obj)
    {
        $user = new User();
        $user->delete();

        $this->assertTrue($user->isDeleted());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::delete
     * @covers       Xpto\Entity\Users\User::isActive
     */
    public function isActiveReturnFalseAfterDeleteMethod($obj)
    {
        $user = new User();
        $user->delete();

        $this->assertFalse($user->isActive());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::delete
     * @covers       Xpto\Entity\Users\User::isNewer
     */
    public function isNewerReturnFalseAfterDeleteMethod($obj)
    {
        $user = new User();
        $user->delete();

        $this->assertFalse($user->isNewer());
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setName
     */
    public function setNameReturnEmptyOnSuccess($obj)
    {
        $user = new User();

        $result = $user->setName($obj->name);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setName
     *
     * @expectedException InvalidArgumentException
     */
    public function setNameThrowsExceptionWhenEmpty($obj)
    {
        $user = new User();
        $user->setName($obj->name);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getName
     */
    public function getNameReturnNameAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'name', $obj->name);

        $this->assertEquals($user->getName(), $obj->name);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getEmail
     */
    public function getEmailReturnEmailAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'email', $obj->email);

        $this->assertEquals($user->getEmail(), $obj->email);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setEmail
     */
    public function setEmailReturnEmptyOnSuccess($obj)
    {
        $user = new User();

        $result = $user->setEmail($obj->email);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setEmail
     *
     * @expectedException InvalidArgumentException
     */
    public function setEmailThrowsInvalidArgumentExceptoinWhenInvalid($obj)
    {
        $user = new User();
        $user->setEmail($obj->email);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setEmail
     *
     * @expectedException InvalidArgumentException
     */
    public function setEmailThrowsInvalidArgumentExceptionWhenEmpty($obj)
    {
        $user = new User();
        $user->setEmail($obj->emailVoid);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::getPassword
     */
    public function getPasswordReturnsPasswordAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'password', $obj->password);

        $this->assertEquals($user->getPassword(), $obj->password);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setPassword
     */
    public function setPasswordReturnsEmptyOnSuccess($obj)
    {
        $user = new User();
        $result = $user->setPassword($obj->password);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setPassword
     *
     * @expectedException InvalidArgumentException
     */
    public function setPasswordThrowsInvalidArgumentExceptionOnEmpty($obj)
    {
        $user = new User();
        $result = $user->setPassword($obj->password);
    }

    /**
     * @test
     *
     * @covers Xpto\Entity\Users\User::getType
     */
    public function getTypeShouldReturnTheTypeAttribute()
    {
        $user = new User();

        $this->modifyAttribute($user, 'type', UserType::CREATIVE);

        $this->assertEquals(UserType::CREATIVE, $user->getType());
    }

    /**
     * @test
     *
     * @dataProvider invalidObjects
     *
     * @covers       Xpto\Entity\Users\User::setType
     *
     * @expectedException InvalidArgumentException
     */
    public function setTypeThrowsExceptionWhenEmptyType($obj)
    {
        $user = new User();
        $user->setType($obj->type);
    }

    /**
     * @test
     *
     * @dataProvider validObjects
     *
     * @covers       Xpto\Entity\Users\User::setType
     */
    public function setTypeEmptyWhenValidValueIsPassed($obj)
    {
        $user = new User();
        $return = $user->setType($obj->type);

        $this->assertEmpty($return);
    }
}
