<?php

namespace Src\Interfaces;

interface ModelInterface
{
   public static function create(array $input);
   public static function update(int $id, array $input);
   public static function delete(int $id);
   public static function find(int $id);
   public static function findAll();
}