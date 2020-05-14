<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Notifications;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 * Notification controller test case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class NotificationTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getAllWithHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/notification/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/notification/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getNotificationByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/notification/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getNotificationByIdThrowsExceptionWhenIdIsInvalidAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/notification/0');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}
