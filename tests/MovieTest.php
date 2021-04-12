<?php

require __DIR__ . '/../bootstrap.php';

use PHPUnit\Framework\TestCase;
use Src\Models\Movie;

class MovieTest extends TestCase
{
    private $http;
    private $token;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => getenv('APP_URL')]);

        $this->token = $this->get_token();
    }

    public function tearDown(): void
    {
        $this->http = null;
        $this->token = null;
    }

    public function test_get_movie()
    {
        $movie = Movie::first();
        $response = $this->http->get("movies/{$movie->id}", [
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Movie', $data['message']);
        $this->assertEquals($movie->id, $data['data']['id']);
        $this->assertEquals($movie->title, $data['data']['title']);
        $this->assertEquals($movie->description, $data['data']['description']);
        $this->assertEquals($movie->year, $data['data']['year']);
        $this->assertEquals($movie->director, $data['data']['director']);
        $this->assertEquals($movie->release_date, $data['data']['release_date']);

    }

    public function test_get_all_movies()
    {
        $movie = Movie::first();
        $response = $this->http->get('movies', [
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Movies list', $data['message']);
        $this->assertEquals($movie->id, $data['data'][0]['id']);
        $this->assertEquals($movie->title, $data['data'][0]['title']);
        $this->assertEquals($movie->description, $data['data'][0]['description']);
        $this->assertEquals($movie->year, $data['data'][0]['year']);
        $this->assertEquals($movie->director, $data['data'][0]['director']);
        $this->assertEquals($movie->release_date, $data['data'][0]['release_date']);
    }

    public function test_create_movie()
    {
        $movie = [
            'title' => 'The Shawshank Redemption',
            'description' => 'Two imprisoned men bond...',
            'year' => 1994,
            'director' => 'Frank Darabont',
            'release_date' => date('Y-m-d H:m:s')
        ];
        $response = $this->http->post('movies', [
            "json" => $movie,
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Created', $data['message']);
        $this->assertEquals($movie['title'], $data['data']['title']);
        $this->assertEquals($movie['description'], $data['data']['description']);
        $this->assertEquals($movie['year'], $data['data']['year']);
        $this->assertEquals($movie['director'], $data['data']['director']);
    }

    public function test_update_movie()
    {
        $movie = Movie::first();
        $response = $this->http->put("movies/{$movie->id}", [
            "json" => [
                'title' => $movie->title,
                'description' => $movie->description,
                'year' => $movie->year,
                'director' => $movie->director,
                'release_date' => $movie->release_date
            ],
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Updated', $data['message']);
        $this->assertEquals($movie->id, $data['data']['id']);
        $this->assertEquals($movie->title, $data['data']['title']);
        $this->assertEquals($movie->description, $data['data']['description']);
        $this->assertEquals($movie->year, $data['data']['year']);
        $this->assertEquals($movie->director, $data['data']['director']);
        $this->assertEquals($movie->release_date, $data['data']['release_date']);
    }

    public function test_delete_movie()
    {
        $movie = Movie::first();
        $response = $this->http->delete("movies/{$movie->id}", [
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Deleted', $data['message']);
    }

    protected function get_token()
    {
        $response = $this->http->post('login', [
            "json" => [
                'email' => getenv('TEST_USER_EMAIL'),
                'password' => getenv('TEST_USER_PASSWORD')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());

        return $data->data->token;
    }
}