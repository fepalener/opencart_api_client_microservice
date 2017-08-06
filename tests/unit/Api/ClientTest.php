<?php
declare(strict_types = 1);

use Test\UnitTestCase;

use App\Api\Client;
use App\Api\Http\Request;
use App\Api\Exception\HttpConnectionErrorException;

class ClientTest extends UnitTestCase
{
    private $apiUrl = 'http://jsonplaceholder.typicode.com';
    private $apiKey = 'test_api_key';
    
    private $client;

    protected function setUp()
    {
        parent::setUp();

        $this->client = new Client($this->apiUrl, $this->apiKey);
    }

    public function testGetRequest()
    {
        try {
            $response = $this->client->makeRequest(new Request('/posts', null, 'GET'));

            $this->assertTrue($response->hasBody());
            $this->assertLessThanOrEqual(226, $response->getCode());
            $this->assertNotEmpty($response->getBody());
        } catch (HttpConnectionErrorException $e) {
            $this->markTestSkipped('This test was skipped because there was a connection problem.');
        }
    }

    public function testPostRequest()
    {
        $testData = [
            'title'  => 'foo',
            'body'   => 'bar',
            'userId' => 1
        ];

        try {
            $response = $this->client->makeRequest(new Request('/posts', $testData, 'POST'));

            $this->assertTrue($response->hasBody());
            $this->assertLessThanOrEqual(226, $response->getCode());
            $this->assertArrayHasKey('id', $response->getBody());
        } catch (HttpConnectionErrorException $e) {
            $this->markTestSkipped('This test was skipped because there was a connection problem.');
        }
    }
}