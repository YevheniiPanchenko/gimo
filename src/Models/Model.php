<?php

namespace Src\Models;

use Src\Interfaces\ModelInterface;
use Src\System\Database;

abstract class Model implements ModelInterface
{
    public static function create(array $input)
    {
        try {
            $connection = static::dbConnection();
            $keys = implode(', ', array_keys($input));
            $values = ':' . implode(', :', array_keys($input));
            $statement = "INSERT INTO " . static::getTableName() . "({$keys}) VALUES ({$values});";
            $statement = $connection->prepare($statement);
            $statement->execute($input);
            return static::getLastTableRecord($connection);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function find(int $id)
    {
        try {
            $connection = static::dbConnection();
            $statement = "SELECT * FROM " . static::getTableName() . " WHERE id = ?;";
            $statement = $connection->prepare($statement);
            $statement->execute([$id]);
            $model = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
            return $model ? $model[0] : null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function findAll()
    {
        try {
            $connection = static::dbConnection();
            $statement = "SELECT * FROM " . static::getTableName();
            $statement = $connection->prepare($statement);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function where($field, $value, $amount = 'first')
    {
        try {
            $connection = static::dbConnection();
            $statement = "SELECT * FROM " . static::getTableName() . " WHERE " . $field ." = ?;";
            $statement = $connection->prepare($statement);
            $statement->execute([$value]);
            if ($amount !== 'first') {
                return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
            }
            $model = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
            return $model ? $model[0] : null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function update(int $id, array $input)
    {
        $str = '';
        foreach (array_keys($input) as $key) {
            $str .=  "{$key} = :{$key}, ";
        }
        $str = substr($str, 0, -2);

        try {
            $connection = static::dbConnection();
            $statement = "UPDATE " . static::getTableName() . " SET {$str} WHERE id = :id;";
            $statement = $connection->prepare($statement);
            $statement->execute(array_merge(['id' => $id], $input));
            return static::find($id);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete(int $id)
    {
        $statement = "DELETE FROM " . static::getTableName() . " WHERE id = :id;";
        try {
            $connection = static::dbConnection();
            $statement = $connection->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function first()
    {
        $statement = "SELECT * FROM " . static::getTableName()  ." ORDER BY ID ASC LIMIT 1";
        try {
            $connection = static::dbConnection();
            $statement = $connection->prepare($statement);
            $statement->execute();
            $model = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
            return $model ? $model[0] : null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    public static function getLastTableRecord($connection)
    {
        $response = "SELECT * FROM " . static::getTableName()  ." ORDER BY ID DESC LIMIT 1";
        $response = $connection->prepare($response);
        $response->execute();
        $model = $response->fetchAll(\PDO::FETCH_CLASS, static::class);
        return $model ? $model[0] : null;
    }

    public static function dbConnection()
    {
        $db = Database::init();
        $connection = $db->getConnection();
        $connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $connection;
    }

    abstract protected static function getTableName(): string;
}