<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Entity\Login;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Xpto\Entity\Login\Token;
use Xpto\Entity\Users\User;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;
use Rhumsaa\Uuid\Uuid;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(name="token")
 * @ORM\Entity
 */
class TokenTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::getUser
     */
    public function getUser()
    {
        $token = new Token();

        $this->modifyAttribute($token, 'user', User::class);

        $this->assertSame(User::class, $token->getUser());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::setUser()
     * @covers \Xpto\Entity\Users\User::isDeleted()
     */
    public function setUser()
    {
        $token = new Token();

        $user = new User();

        $this->assertEmpty($token->setUser($user));
    }

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::getContent()
     */
    public function getContent()
    {
        $value = Uuid::uuid4()->toString();

        $token = new Token();

        $this->modifyAttribute($token, 'content', $value);

        $this->assertEquals($value, $token->getContent());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::setContent()
     */
    public function setContent()
    {
        $value = Uuid::uuid4()->toString();

        $token = new Token();

        $this->assertEmpty($token->setContent($value));
    }

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::getExpiration()
     */
    public function getExpiration()
    {
        $today = new DateTime();

        $token = new Token();

        $this->modifyAttribute($token, 'expiration', $today);

        $this->assertSame($today, $token->getExpiration());
    }

    /**
     * @test
     * @covers \Xpto\Entity\Login\Token::setExpiration
     */
    public function setExpiration()
    {
        $expiration = new DateTime();

        $token = new Token();

        $this->assertEmpty($token->setExpiration($expiration));
    }
}
