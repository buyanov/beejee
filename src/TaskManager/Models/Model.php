<?php

declare(strict_types=1);

namespace TaskManager\Models;

use TaskManager\Models\Traits\HasChanges;

abstract class Model implements ModelInterface
{
    use HasChanges;

    public function __construct()
    {
        $this->sync();
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        unset($vars['original']);

        return $vars;
    }

    public static function find(int $id): ModelInterface
    {
        return (app()->getDB()->find(static::class, $id))->sync();
    }

    public function save(): void
    {
        db()->persist($this);
        db()->flush();
    }
}
