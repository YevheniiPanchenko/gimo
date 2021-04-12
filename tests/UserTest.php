<?php

require __DIR__ . '/../bootstrap.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => getenv('APP_URL')]);
    }

    public function tearDown(): void
    {
        $this->http = null;
        $this->token = null;
    }

    public function test_login()
    {
        $response = $this->http->post("login", [
            'json' => [
                'email' => getenv('TEST_USER_EMAIL'),
                'password' => getenv('TEST_USER_PASSWORD')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Token', $data['message']);
    }
}