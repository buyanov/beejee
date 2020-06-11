<?php

declare(strict_types=1);

namespace TaskManager\Models;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class TaskRepository extends EntityRepository
{
    public function sortByName(string $direction = 'ASC'): Query
    {
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        return $this->_em->createQuery("SELECT t FROM TaskManager\Models\Task t ORDER BY t.username $direction");
    }
}
