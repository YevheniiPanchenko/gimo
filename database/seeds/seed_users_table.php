<?php

require __DIR__ . '/../../bootstrap.php';

use Src\Models\User;

try {

    User::create([
        'email' => getenv('TEST_USER_EMAIL'),
        'password' =>  password_hash(getenv('TEST_USER_PASSWORD'), PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:m:s')
    ]);

    echo 'seeded successfully ';
} catch (\PDOException $e) {
    exit($e->getMessage());
}