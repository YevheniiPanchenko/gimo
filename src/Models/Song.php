<?php

namespace Src\Models;

class Song extends Model
{
    protected static function getTableName(): string
    {
        return 'songs';
    }
}