<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Login;

use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Auth\Login as LoginService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery as m;
use PHPUnit_Framework_TestCase;
use Rhumsaa\Uuid\Uuid;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Login service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class LoginTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateEmMock
     */
    use CreateEmMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Entity\Entity::setStatus()
     * @covers \Xpto\Entity\Entity::isDeleted()
     * @covers \Xpto\Service\Auth\Login::validateCredentials()
     * @covers \Xpto\Service\Auth\Login::getToken()
     * @covers \Xpto\Entity\Users\User::getPassword()
     * @covers \Xpto\Entity\Users\User::setEmail()
     * @covers \Xpto\Repository\Users\User::__construct()
     * @covers \Xpto\Repository\Users\User::findByEmail()
     * @covers \Xpto\Password::verify()
     */
    public function validateCredentials()
    {
        $username = 'teste@teste.net';
        $password = 'xxxxx';

        $service = new LoginService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $service->validateCredentials($username, $password);
    }

    /**
     * @test
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Entity\Entity::setStatus()
     * @covers \Xpto\Entity\Login\Token::setContent()
     * @covers \Xpto\Service\Auth\Login::getToken()
     * @covers \Xpto\Service\Auth\Login::validateToken()
     */
    public function validateToken()
    {
        $token = '25769c6c-d34d-4bfe-ba98-e0ee856f3e7a';

        $service = new LoginService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $validate = $service->validateToken($token);

        $this->assertNotNull($validate);
    }

    /**
     * @test
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Entity\Entity::setStatus()
     * @covers \Xpto\Entity\Login\Token::setContent()
     * @covers \Xpto\Service\Auth\Login::getToken()
     * @covers \Xpto\Service\Auth\Login::validateToken()
     */
    public function validateTokenUuid()
    {
        $token = '25769c6c-d34d-4bfe-ba98-e0ee856f3e7a';

        $this->assertTrue(Uuid::isValid($token));
    }

    /**
     * @test
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Service\Login\Login::getToken()
     */
    public function getToken()
    {
        $token = '25769c6c-d34d-4bfe-ba98-e0ee856f3e7a';

        $service = new LoginService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $validate = $service->getToken($token);

        $this->assertNotNull($validate);
    }

    /**
     * @test
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Entity\Entity::setStatus()
     * @covers \Xpto\Entity\Entity::setCreated()
     * @covers \Xpto\Entity\Entity::setUpdated()
     * @covers \Xpto\Entity\Entity::isDeleted()
     * @covers \Xpto\Entity\Login\Token::setUser()
     * @covers \Xpto\Entity\Login\Token::setContent()
     * @covers \Xpto\Service\Auth\Login::getNewTokenForUser()
     * @covers \Rhumsaa\Uuid\Uuid::uuid4()
     * @covers \DateInterval::__construct()
     * @covers \Xpto\Entity\Login\Token::setStatus()
     * @covers \Xpto\Entity\Login\Token::setExpiration()
     * @covers \Xpto\Entity\Login\Token::setAddress()
     * @covers \Xpto\Entity\Login\Token::setAgent()
     */
    public function getNewTokenForUser()
    {
        $mock = m::mock(Request::class);
        $mock->shouldReceive('getClientIp')
            ->andReturn('::1')
            ->byDefault();

        $headerbag = m::mock(HeaderBag::class);
        $headerbag->shouldReceive('get')
            ->andReturn('test')
            ->byDefault();

        $mock->headers = $headerbag;

        $service = new LoginService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $validate = $service->getNewTokenForUser(new UserModel(), $mock);

        $this->assertNotNull($validate);
    }

    /**
     * @test
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Entity\Entity::isDeleted()
     * @covers \Xpto\Entity\Entity::setStatus()
     * @covers \Xpto\Entity\Login\Token::getUser()
     * @covers \Xpto\Entity\Login\Token::setContent()
     * @covers \Xpto\Service\Auth\Login::getToken()
     * @covers \Xpto\Service\Auth\Login::loadUserByToken()
     * @covers \Xpto\Repository\Users\User::__construct()
     * @covers \Xpto\Repository\Users\User::findByToken()
     * @covers \Xpto\Repository\Users\Profile::__construct()
     * @covers \Xpto\Repository\Users\Profile::findByUser()
     */
    public function loadUserByToken()
    {
        $token = '25769c6c-d34d-4bfe-ba98-e0ee856f3e7a';

        $service = new LoginService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $validate = $service->loadUserByToken($token);

        $this->assertTrue(is_object($validate));
    }
}
