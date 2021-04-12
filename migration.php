<?php

try {
    foreach (glob(__DIR__ . "/database/migrations/*.php") as $filename) {
        exec( 'php ' . $filename, $output);
        echo($output[0]);
    }
} catch (\PDOException $e) {
    exit($e->getMessage());
}