<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Signup;

use Xpto\Tests\ApplicationControllerTestCase;
use Domain\Value\Category;
use Domain\Value\Gender;
use Domain\Value\Work\Area as WorkArea;
use Domain\Value\Work\Type as WorkType;
use Silex\WebTestCase;

/**
 * Signup Controller test case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class SignupTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        $objMale = [
            "name" => "Ciclano de Tal",
            "email" => "teste-" . sha1(uniqid()) . "@teste.net",
            "password" => "lalala",
            "birth" => "2014-11-28T17:49:01-0200",
            "gender" => Gender::MALE,
            "nickname" => sha1(uniqid()),
            "biorelease" => "um cara",
            "fullrelease" => "um cara com um release",
            "site" => "marcelaraujo.com.br",
            "work_type" => WorkType::PRODUCER,
            "work_area" => WorkArea::FILMMAKER,
            "category" => Category::BUSINESS,
            'location_born' => 'Florianópolis - SC',
            'location_live' => 'Florianópolis - SC',
        ];

        $objFemale = [
            "name" => "Fulana de tal",
            "email" => "teste-" . sha1(uniqid()) . "@teste.net",
            "password" => "lalala",
            "birth" => "2014-11-28T17:49:01-0200",
            "gender" => Gender::FEMALE,
            "nickname" => sha1(uniqid()),
            "biorelease" => "alguem qualquer",
            "fullrelease" => "preguica de escrever um release",
            "site" => "fulana.com.br",
            "work_type" => WorkType::AGENCY,
            "work_area" => WorkArea::MODEL,
            "category" => Category::FASHION,
            'location_born' => 'Florianópolis - SC',
            'location_live' => 'Florianópolis - SC',
        ];

        return [
            [
                $objMale
            ],
            [
                $objFemale
            ]
        ];
    }

    /**
     * @test
     */
    public function postUserWithoutParametersAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/signup/');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postUserWithoutParametersAndWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/signup/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postUserWithFullParameters($obj)
    {
        unset($this->header['HTTP_Authorization']);

        $client = $this->createClient();
        $client->request('POST', '/signup/', $obj, [], $this->header);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
