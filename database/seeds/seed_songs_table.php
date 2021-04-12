<?php

require __DIR__ . '/../../bootstrap.php';

use Src\Models\Song;

try {
    Song::create([
        'title' => 'Best music album ever',
        'album_name' => 'Bad',
        'year' => '1987',
        'artist' => 'Michael Jackson',
        'release_date' => date('Y-m-d H:m:s')
    ]);
    echo 'seeded successfully ';
} catch (\PDOException $e) {
    exit($e->getMessage());
}