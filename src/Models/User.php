<?php

namespace Src\Models;

class User extends Model
{
    protected static function getTableName(): string
    {
        return 'users';
    }
}