<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Trusteeship;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 * Trusteedship Test cas
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class TrusteeshipTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/trusteeship/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/trusteeship/', [], [], $this->header);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithCuratorAuthHeader()
    {
        $this->header['HTTP_Authorization'] = $this->authCurator;

        $client = $this->createClient();
        $client->request('GET', '/trusteeship/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function approveWithoutAuthHeaders()
    {
        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/approve/1');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function approveWithAuthHeaders()
    {
        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/approve/1', [], [], $this->header);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function approveWithCuratorAuthHeaders()
    {
        $this->header['HTTP_Authorization'] = $this->authCurator;

        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/approve/1', [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function declineWithoutAuthHeaders()
    {
        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/decline/1');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function declineWithAuthHeaders()
    {
        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/decline/1', [], [], $this->header);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function declineWithCuratorAuthHeaders()
    {
        $this->header['HTTP_Authorization'] = $this->authCurator;

        $client = $this->createClient();
        $client->request('PUT', '/trusteeship/decline/1', [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
