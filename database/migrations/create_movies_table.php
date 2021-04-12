<?php

require __DIR__ . '/../../bootstrap.php';

use Src\System\Database;

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS movies (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(150) NULL DEFAULT NULL,
        description VARCHAR(300) NULL DEFAULT NULL,
        `year` YEAR NULL DEFAULT NULL,
        director VARCHAR(100) NULL DEFAULT NULL,
        release_date TIMESTAMP NULL DEFAULT NULL,
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