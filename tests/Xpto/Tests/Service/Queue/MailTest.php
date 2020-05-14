<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Queue;

use Xpto\Entity\Queue\Mail as MailModel;
use Xpto\Service\Queue\Mail as MailService;
use Xpto\Tests\ChangeProtectedAttribute;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use PHPUnit_Framework_TestCase;

/**
 * Mail Queue Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class MailTest extends PHPUnit_Framework_TestCase
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
     *
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Service\Queue\Mail::save()
     */
    public function save()
    {
        $service = new MailService();

        $this->modifyAttribute($service, 'em', $this->getDefaultEmMock());

        $mail = new MailModel();

        $this->assertSame($mail, $service->save($mail));
    }
}
