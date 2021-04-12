<?php

require __DIR__ . '/../../bootstrap.php';

use Src\System\Database;

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        created_at TIMESTAMP NULL DEFAULT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;
EOS;

try {
    $db = Database::init();
    $connection = $db->getConnection();
    $createTable = $connection->exec($statement);
    echo "table has been created if not exists.";
} catch (\PDOException $e) {
    exit($e->getMessage());
}