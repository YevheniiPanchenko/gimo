<?php

require __DIR__ . '/../../bootstrap.php';

use Src\Models\Movie;

try {
    Movie::create([
        'title' => 'The Shawshank Redemption',
        'description' => 'Two imprisoned men bond...',
        'year' => '1994',
        'director' => 'Frank Darabont',
        'release_date' => date('Y-m-d H:m:s')
    ]);
    echo 'seeded successfully ';
} catch (\PDOException $e) {
    exit($e->getMessage());
}