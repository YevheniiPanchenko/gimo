<?php

use Src\Controllers\MovieController;
use Src\Controllers\SongController;
use Src\Controllers\UsersController;
use Src\System\Request;
use Src\System\Router;

$router = new Router(new Request);
$users = new UsersController();
$movie = new MovieController();
$song = new SongController();

$router->get('/', function() {
    return 'api';
});

$router->post('/login', function($request) use ($users) {
    return $users->login($request);
});

// Movies

$router->get('/movies', function($request) use ($movie) {
    return $movie->getAlL($request);
});

$router->get('/movies/{id}', function($request) use ($movie) {
    return $movie->get($request);
});

$router->post('/movies', function($request) use ($movie) {
    return $movie->create($request);
});

$router->put('/movies/{id}', function($request) use ($movie) {
    return $movie->update($request);
});

$router->delete('/movies/{id}', function($request) use ($movie) {
    return $movie->delete($request);
});

// Songs

$router->get('/songs', function($request) use ($song) {
    return $song->getAlL($request);
});

$router->get('/songs/{id}', function($request) use ($song) {
    return $song->get($request);
});

$router->post('/songs', function($request) use ($song) {
    return $song->create($request);
});

$router->put('/songs/{id}', function($request) use ($song) {
    return $song->update($request);
});

$router->delete('/songs/{id}', function($request) use ($song) {
    return $song->delete($request);
});