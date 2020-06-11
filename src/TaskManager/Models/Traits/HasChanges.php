<?php

declare(strict_types=1);

namespace TaskManager\Models\Traits;

use TaskManager\Models\ModelInterface;

trait HasChanges
{
    protected $original = [];

    public function sync(): ModelInterface
    {
        $this->original = $this->toArray();

        return $this;
    }

    public function compareWithOriginal($key): bool
    {
        if (!array_key_exists($key, $this->original)) {
            return false;
        }
        $attrs = $this->toArray();

        return $attrs[$key] === $this->original[$key];
    }

    public function getChanges(): array
    {
        $changes = [];

        foreach ($this->toArray() as $key => $value) {
            if (!$this->compareWithOriginal($key)) {
                $changes[$key] = $value;
            }
        }

        return $changes;
    }

    public function isChanged($attributes): bool
    {
        if (is_array($attributes)) {
            return !empty(array_diff(array_flip($attributes), $this->getChanges()));
        }

        return array_key_exists($attributes, $this->getChanges());
    }
}
