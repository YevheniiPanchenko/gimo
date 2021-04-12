<?php

namespace Src\Models;

class Movie extends Model
{
    protected static function getTableName(): string
    {
        return 'movies';
    }
}