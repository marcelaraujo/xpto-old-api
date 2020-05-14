<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Inbox;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class InboxTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        return [
            [
                [
                    'destination' => 2,
                    'body' => 'Hi :)',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function getAll()
    {
        $client = $this->createClient();
        $client->request('GET', '/inbox/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getInboxByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/inbox/' . uniqid(), [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getInboxByIdThrowsExceptionWhenIdNotExists()
    {
        $client = $this->createClient();
        $client->request('GET', '/inbox/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postInboxWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('POST', '/inbox/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postInboxWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/inbox/', $obj, [], $this->header, json_encode($obj));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteWithValidMessage()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/inbox/1', [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteWithInvalidIdThrowsMethodNotAllowedError()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/inbox/' . uniqid(), [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteWithInvalidIdThrowsNotFoundError()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/inbox/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function archiveWithValidMessage()
    {
        $client = $this->createClient();
        $client->request('POST', '/inbox/archive/2', [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
