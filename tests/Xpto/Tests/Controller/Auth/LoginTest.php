<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Auth;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class LoginTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/login/');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/login/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/login/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAllWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/login/', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
