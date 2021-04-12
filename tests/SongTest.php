<?php

require __DIR__ . '/../bootstrap.php';

use PHPUnit\Framework\TestCase;
use Src\Models\Song;

class SongTest extends TestCase
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

    public function test_get_song()
    {
        $song = Song::first();
        $response = $this->http->get("songs/$song->id", [
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Song', $data['message']);
        $this->assertEquals($song->id, $data['data']['id']);
        $this->assertEquals($song->title, $data['data']['title']);
        $this->assertEquals($song->album_name, $data['data']['album_name']);
        $this->assertEquals($song->year, $data['data']['year']);
        $this->assertEquals($song->artist, $data['data']['artist']);
        $this->assertEquals($song->release_date, $data['data']['release_date']);
    }

    public function test_get_all_song()
    {
        $song = Song::first();
        $response = $this->http->get('songs', [
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Songs list', $data['message']);
        $this->assertEquals($song->id, $data['data'][0]['id']);
        $this->assertEquals($song->title, $data['data'][0]['title']);
        $this->assertEquals($song->album_name, $data['data'][0]['album_name']);
        $this->assertEquals($song->year, $data['data'][0]['year']);
        $this->assertEquals($song->artist, $data['data'][0]['artist']);
        $this->assertEquals($song->release_date, $data['data'][0]['release_date']);
    }

    public function test_create_song()
    {
        $song = [
            'title' => 'Best music album ever',
            'album_name' => 'Bad',
            'year' => 1987,
            'artist' => 'Michael Jackson',
            'release_date' => date('Y-m-d H:m:s')
        ];
        $response = $this->http->post('songs', [
            "json" => $song,
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Created', $data['message']);
        $this->assertEquals($song['title'], $data['data']['title']);
        $this->assertEquals($song['album_name'], $data['data']['album_name']);
        $this->assertEquals($song['year'], $data['data']['year']);
        $this->assertEquals($song['artist'], $data['data']['artist']);
    }

    public function test_update_song()
    {
        $song = Song::first();
        $response = $this->http->put("songs/{$song->id}", [
            "json" => [
                'title' => $song->title,
                'album_name' => $song->album_name,
                'year' => $song->year,
                'artist' => $song->artist,
                'release_date' => $song->release_date
            ],
            'headers' => ['Authorization' => "Bearer {$this->token}"]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data['success']);
        $this->assertEquals('Updated', $data['message']);
        $this->assertEquals($song->id, $data['data']['id']);
        $this->assertEquals($song->title, $data['data']['title']);
        $this->assertEquals($song->album_name, $data['data']['album_name']);
        $this->assertEquals($song->year, $data['data']['year']);
        $this->assertEquals($song->artist, $data['data']['artist']);
        $this->assertEquals($song->release_date, $data['data']['release_date']);
    }

    public function test_delete_song()
    {
        $song = Song::first();
        $response = $this->http->delete("songs/{$song->id}", [
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